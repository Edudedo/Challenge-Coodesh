<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Favorite;

class UserController extends Controller
{
     // Funcao para ver o perfil do usuario
     public function profile()
     {
         return response()->json(auth('sanctum')->user());
     }
 
     // Funcao para ver o historico de palavras
     public function history()
     {
         $user = auth('sanctum')->user();
 
         $histories = $user->histories()->with('word')->paginate(10);
 
         return response()->json($histories);
     }
 
     // Funcao para ver as palavras favoritas
     public function favorites()
     {
         $user = auth('sanctum')->user();
 
         $favorites = $user->favorites()->with('word')->paginate(10);
 
         return response()->json($favorites);
     }
}
