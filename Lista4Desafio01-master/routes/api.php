<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

Route::post("/auth/register", [AuthController::class, 'register']);
Route::post("/auth/login", [AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/auth/logout', [AuthController::class,'logout']);
    Route::get('/me', function(Request $request)
    {
        return $request->user();
        }
        );
        Route::get('/posts', [PostController::class, 'index']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::put('/posts/{id}', [PostController::class, 'update']);
        Route::delete('/posts/{id}', [PostController::class,'destroy']);
        Route::patch('/posts/{id}/archive', [PostController::class, 'archive']);
        
        Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
        Route::delete('/comments/{id}', [CommentController::class,'destroy']);
        Route::get('/posts/{id}', [PostController::class, 'show']);
        Route::get('/posts/{id}/comments', [CommentController::class,'index']);
});
