<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/me', function () {
        $user = Auth::user();
        return response()->json($user);
    });
});

Route::post('/auth/signup', [AuthController::class, 'signup']);

Route::post('/auth/signin', [AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/entries/en', [WordController::class, 'list']);
    Route::get('/entries/en/{word}', [WordController::class, 'show']);
    Route::post('/entries/en/{word}/favorite', [WordController::class, 'favorite']);
    Route::delete('/entries/en/{word}/unfavorite', [WordController::class, 'unfavorite']);
});