<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function list(Request $request) {
        $query = Word::query();
    
        if ($request->has('search')) {
            $query->where('word', 'like', '%' . $request->search . '%');
        }
    
        $words = $query->paginate($request->get('limit', 10));
    
        return response()->json($words);
    }
    
    public function show($word) {
        $wordDetails = Word::where('word', $word)->firstOrFail();
    
        Auth::user()->history()->create(['word_id' => $wordDetails->id]);
    
        return response()->json($wordDetails);
    }
    
    public function favorite($word) {
        $wordDetails = Word::where('word', $word)->firstOrFail();
    
        Auth::user()->favorites()->create(['word_id' => $wordDetails->id]);
    
        return response()->json(['message' => 'Word favorited']);
    }
    
    public function unfavorite($word) {
        $wordDetails = Word::where('word', $word)->firstOrFail();
    
        Auth::user()->favorites()->where('word_id', $wordDetails->id)->delete();
    
        return response()->json(['message' => 'Word unfavorited']);
    }
}
