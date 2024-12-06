<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

//Rota para retornar o profile, historico e palavras favoritas
Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum', 'throttle:api',])->group(function () {
    Route::get('/user/me', function () {
        $user = auth('sanctum')->user();
        return response()->json($user);
    });
    Route::get('/user/me/history', [UserController::class, 'history']);
    Route::get('/user/me/favorites', [UserController::class, 'favorites']);
    //Rotas de registro e login
    Route::post('/auth/signup', [AuthController::class, 'signup']);
    Route::post('/auth/signin', [AuthController::class, 'signin']);
    //Grupo de rotas para mostrar , favoritar e desfavoritar alguma palavra
    Route::get('/entries/en', [WordController::class, 'list']);
    Route::get('/entries/en/{word}', [WordController::class, 'show']);
    Route::post('/entries/en/{word}/favorite', [WordController::class, 'favorite']);
    Route::delete('/entries/en/{word}/unfavorite', [WordController::class, 'unfavorite']);
});






