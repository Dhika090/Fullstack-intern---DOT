<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('{id}', [PostController::class, 'show'])->name('api.posts.show');
    Route::post('/', [PostController::class, 'store'])->name('api.posts.store');
    Route::put('{id}', [PostController::class, 'update'])->name('api.posts.update');
    Route::delete('{id}', [PostController::class, 'destroy'])->name('api.posts.destroy');
});
