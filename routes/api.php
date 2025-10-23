<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Models\Posts;
use Dom\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class,'me']);
    Route::get("/logout", [AuthController::class,"logout"]);
    Route::post("/post", [PostsController::class,"store"]);
    Route::patch("/post/{id}", [PostsController::class,"update"]);
    Route::delete("/post/{id}", [PostsController::class,"destroy"]);

    Route::get("/comment", [CommentsController::class,"index"]);
    Route::get("/comment/{id}", [CommentsController::class,"show"]);
    Route::post("/comment", [CommentsController::class,"store"]);
    Route::patch("/comment/{id}", [CommentsController::class,"update"]);
    Route::delete("/comment/{id}", [CommentsController::class,"destroy"]);
});

Route::get("/post", [PostsController::class,"index"]);
Route::get("/post/{id}", [PostsController::class, "show"]);


Route::post("/login", [AuthController::class,"login"]);
