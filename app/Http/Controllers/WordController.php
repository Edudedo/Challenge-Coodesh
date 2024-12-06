<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{

    //funcao para listar as palavras
    public function list(Request $request) {
        $search = $request->query('search', '');
        $limit = $request->query('limit', 10);

        $words = Word::where('word', 'like', "%{$search}%")->paginate($limit);

        return response()->json([
            'results' => $words->items(),
            'totalDocs' => $words->total(),
            'page' => $words->currentPage(),
            'totalPages' => $words->lastPage(),
            'hasNext' => $words->hasMorePages(),
            'hasPrev' => $words->currentPage() > 1,
        ]);
    }
    
    //funcao para registrar no histórico e ver os detalhes da palavra
    public function show($word)
    {
        $word = Word::where('word', $word)->firstOrFail();

        $user = auth('sanctum')->user();
        $user->histories()->create(['word_id' => $word->id]);

        return response()->json($word);
    }
    
    public function favorite($word)
    {
        $word = Word::where('word', $word)->firstOrFail();
        
        $user = auth('sanctum')->user();

        $user->favorites()->create(['word_id' => $word->id]);

        return response()->json(['message' => 'Palavra adicionada aos favoritos']);
    }
    
    public function unfavorite($word)
    {
        $word = Word::where('word', $word)->firstOrFail();
        $user = auth('sanctum')->user();

        $user->favorites()->where('word_id', $word->id)->delete();

        return response()->json(['message' => 'Word removed from favorites.']);
    }
}
