<?php

namespace App\Livewire;

use App\Events\NewCommentAdded;
use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class CommentCreate extends Component
{
    public string $comment = '';

    public Post $post;

    public ?Comment $commentModel = null;
    public ?Comment $parentComment = null;

    public function mount(Post $post, $commentModel = null, $parentComment = null)
    {
        $this->post = $post;
        $this->commentModel = $commentModel;
        $this->comment = $commentModel ? $commentModel->comment : '';

        $this->parentComment = $parentComment;
    }

    public function render()
    {
        return view('livewire.comment-create');
    }

    public function createComment()
    {
        $user = auth()->user();

        if (!$user) {
            return $this->redirect('/login');
        }

        if ($this->commentModel) {
            if ($this->commentModel->user_id != $user->id || $user->hasRole('admin2')) {
                $this->commentModel->comment = $this->comment;
                $this->commentModel->save();

                $this->comment = '';
                $this->dispatch('commentUpdated');
            } else {
                return response('You are not allowed to perform this action', 403);
            }



        } else {
            $comment = Comment::create([
                'comment' => $this->comment,
                'post_id' => $this->post->id,
                'user_id' => $user->id,
                'parent_id' => $this->parentComment?->id
            ]);

            $this->comment = '';
            $this->dispatch('commentCreated', $comment->id);
            event(new NewCommentAdded($comment));

        }
    }

}
