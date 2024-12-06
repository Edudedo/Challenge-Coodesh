<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WordController extends Controller
{

    //funcao para listar as palavras
    public function list(Request $request) {
        $search = $request->query('search', '');
        $limit = $request->query('limit', 10);

        $cacheKey = "words_search_{$search}_limit_{$limit}";

        $start = microtime(true);

        $words = Cache::remember($cacheKey, 3600, function () use ($search, $limit) {
            return Word::where('word', 'like', "%{$search}%")->paginate($limit);
        });

        $end = microtime(true);

        $cacheStatus = Cache::has($cacheKey) ? 'HIT' : 'MISS';

        return response()->json([
            'results' => $words->items(),
            'totalDocs' => $words->total(),
            'page' => $words->currentPage(),
            'totalPages' => $words->lastPage(),
            'hasNext' => $words->hasMorePages(),
            'hasPrev' => $words->currentPage() > 1,
        ])
        ->header('x-cache', $cacheStatus)
        ->header('x-respose-time', round(($end - $start) * 1000, 2) . 'ms');
    }
    
    //funcao para registrar no histórico e ver os detalhes da palavra
    public function show($word)
    {
        
    $cacheKey = "word_details_{$word}";

    $start = microtime(true);

    $wordDetails = Cache::remember($cacheKey, 3600, function () use ($word) {
    
        return Word::where('word', $word)->firstOrFail();
    });

    $end = microtime(true);

    $cacheStatus = Cache::has($cacheKey) ? 'HIT' : 'MISS';

    return response()->json($wordDetails)
        ->header('x-cache', $cacheStatus)
        ->header('x-response-time', round(($end - $start) * 1000, 2) . 'ms');
    }
    
    public function favorite($word)
    {
        $wordModel = Word::where('word', $word)->firstOrFail();

        $user = auth('sanctum')->user();
        $user->favorites()->create(['word_id' => $wordModel->id]);
    
        Cache::forget("user_{$user->id}_favorites");
    
        return response()->json(['message' => 'Palavra adicionada aos favoritos'], 201);
    }
    
    public function unfavorite($word)
    {
        $wordModel = Word::where('word', $word)->firstOrFail();

        $user = auth('sanctum')->user();
    
        $user->favorites()->where('word_id', $wordModel->id)->delete();
    
        Cache::forget("user_{$user->id}_favorites");
    
        return response()->json(['message' => 'Palavra removida dos favoritos']);
    }
}
