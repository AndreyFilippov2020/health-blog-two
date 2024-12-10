<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function home(): View
    {
        // Latest post
        $latestPost = Post::where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->first();

        // Most popular posts based on upvotes
        $popularPosts = Post::query()
            ->leftJoin('upvote_downvotes', 'posts.id', '=', 'upvote_downvotes.post_id')
            ->selectRaw('posts.*, COUNT(upvote_downvotes.id) as upvote_count')
            ->where(function ($query) {
                $query->whereNull('upvote_downvotes.is_upvote')
                    ->orWhere('upvote_downvotes.is_upvote', 1);
            })
            ->where('posts.active', 1)
            ->whereDate('posts.published_at', '<', Carbon::now())
            ->groupBy('posts.id') // Используем только `id` для группировки
            ->orderByDesc('upvote_count')
            ->limit(5)
            ->get();

        // Recommended or popular posts
        $user = auth()->user();

        if ($user) {
            $recommendedPosts = Post::query()
                ->select('posts.*')
                ->distinct()
                ->whereIn('posts.id', function ($query) use ($user) {
                    $query->select('cp2.post_id')
                        ->from('category_post as cp1')
                        ->join('upvote_downvotes', 'upvote_downvotes.post_id', '=', 'cp1.post_id')
                        ->join('category_post as cp2', 'cp1.category_id', '=', 'cp2.category_id')
                        ->where('upvote_downvotes.user_id', $user->id)
                        ->where('upvote_downvotes.is_upvote', 1);
                })
                ->where('posts.active', 1)
                ->whereDate('posts.published_at', '<', Carbon::now())
                ->limit(3)
                ->get();
        } else {
            $recommendedPosts = Post::query()
                ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->selectRaw('posts.*, COUNT(post_views.id) as view_count')
                ->where('posts.active', 1)
                ->whereDate('posts.published_at', '<', Carbon::now())
                ->groupBy('posts.id')
                ->orderByDesc('view_count')
                ->limit(3)
                ->get();
        }

        // Recent categories with their latest posts
        $categories = Category::query()
            ->selectRaw('categories.*, MAX(posts.published_at) as max_date')
            ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
            ->leftJoin('posts', 'category_post.post_id', '=', 'posts.id')
            ->where('posts.active', 1)
            ->whereDate('posts.published_at', '<', Carbon::now())
            ->groupBy('categories.id')
            ->orderByDesc('max_date')
            ->limit(5)
            ->get();

        return view('home', compact('latestPost', 'popularPosts', 'recommendedPosts', 'categories'));
    }

    public function show(Post $post, Request $request)
    {
        if (!$post->active || (!$post->published_at && $post->published_at->greaterThan(Carbon::now()))) {
            throw new NotFoundHttpException();
        }

        $next = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $prev = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        $user = $request->user();

        $recentView = PostView::query()
            ->where('post_id', $post->id)
            ->where(function ($query) use ($user, $request) {
                if ($user) {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('ip_address', $request->ip());
                }
            })
            ->where('created_at', '>=', Carbon::now()->subHour())
            ->exists();

        if (!$recentView) {
            PostView::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'post_id' => $post->id,
                'user_id' => $user?->id
            ]);
        }

        return view('post.view', compact('post', 'next', 'prev'));
    }

    public function byCategory(Category $category)
    {
        $posts = Post::query()
            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('category_post.category_id', $category->id)
            ->where('posts.active', 1)
            ->whereDate('posts.published_at', '<=', Carbon::now())
            ->orderBy('posts.published_at', 'desc')
            ->paginate(10);

        return view('post.index', compact('posts', 'category'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $posts = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhere('body', 'like', "%$q%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('post.search', compact('posts'));
    }
}
