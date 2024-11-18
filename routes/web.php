<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/about-us', [SiteController::class, 'about'])->name('about-us');
Route::get('/categories/{category:slug}', [PostController::class, 'byCategory'])->name('by-category');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('view');
