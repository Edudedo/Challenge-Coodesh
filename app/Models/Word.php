<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',      
        'details',   
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}