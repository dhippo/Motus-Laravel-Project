<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotusWord extends Model
{
    use HasFactory;

    protected $table = 'motus_words';

    protected $fillable = [
        'entire_word',
        'word_date'
    ];

    protected $casts = [
        'word_date' => 'date', // Convertit automatiquement en instance Carbon
    ];

    public function games()
    {
        return $this->hasMany(MotusGame::class, 'word_id');
    }
}

