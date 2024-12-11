<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/unsubscribe/{id}', function ($id) {
        $user = User::findOrFail($id);
        $user->update(['is_subscribed' => false]);

        return response('You have successfully unsubscribed from notifications.', 200);
    })->name('unsubscribe');
});

require __DIR__ . '/auth.php';

Route::get('/', [PostController::class, 'home'])->name('home');
Route::get('/search', [PostController::class, 'search'])->name('search');
Route::get('/about-us', [SiteController::class, 'about'])->name('about-us');
Route::get('/categories/{category:slug}', [PostController::class, 'byCategory'])->name('by-category');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('view');
Route::get('/policy', function () {
    return view('/policy/policy');
})->name('policy');
