<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/about-us', [SiteController::class, 'about'])->name('about-us');
Route::get('/categories/{category:slug}', [PostController::class, 'byCategory'])->name('by-category');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('view');
