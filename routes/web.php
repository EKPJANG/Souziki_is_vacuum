<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CategoryController;

Route::get('/', [PostController::class, 'index'])->name('home');

// 投稿関連のルート
Route::resource('posts', PostController::class);

// コメント関連のルート
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// いいね関連のルート
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('likes.destroy');

// カテゴリー関連のルート
Route::resource('categories', CategoryController::class);