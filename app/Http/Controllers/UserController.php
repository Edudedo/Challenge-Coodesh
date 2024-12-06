<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Favorite;
use Illuminate\Support\Facades\Cache;
class UserController extends Controller
{
     // Funcao para ver o perfil do usuario
     public function profile()
     {
        $user = auth('sanctum')->user();

        $cacheKey = "user_profile_{$user->id}";

        $start = microtime(true);
    
        $userProfile = Cache::remember($cacheKey, 3600, function () use ($user) {
            return $user->load(['favorites', 'histories']); 
        });
    
        $end = microtime(true);
    
        $cacheStatus = Cache::has($cacheKey) ? 'HIT' : 'MISS';
    
        return response()->json($userProfile)
            ->header('x-cache', $cacheStatus)
            ->header('x-response-time', round(($end - $start) * 1000, 2) . 'ms');
     }
 
     // Funcao para ver o historico de palavras
     public function history()
     {
        $user = auth('sanctum')->user();

    $cacheKey = "user_{$user->id}_history";

    $start = microtime(true);

    $history = Cache::remember($cacheKey, 3600, function () use ($user) {
        
        return $user->histories()->with('word')->get();
    });

    $end = microtime(true);

    $cacheStatus = Cache::has($cacheKey) ? 'HIT' : 'MISS';

    return response()->json($history)
        ->header('x-cache', $cacheStatus)
        ->header('x-response-time', round(($end - $start) * 1000, 2) . 'ms');
     }
 
     // Funcao para ver as palavras favoritas
     public function favorites()
     {
        $user = auth('sanctum')->user();

        $cacheKey = "user_{$user->id}_favorites";
    
        $start = microtime(true);
    
        $favorites = Cache::remember($cacheKey, 3600, function () use ($user) {
 
            return $user->favorites()->with('word')->get();
        });
    
        $end = microtime(true);

        $cacheStatus = Cache::has($cacheKey) ? 'HIT' : 'MISS';
    
        return response()->json($favorites)
            ->header('x-cache', $cacheStatus)
            ->header('x-response-time', round(($end - $start) * 1000, 2) . 'ms');
     }
}
