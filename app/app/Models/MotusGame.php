<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/app/Models/MotusGame.php
class MotusGame extends Model
{
    use HasFactory;

    // Définissez les champs qui peuvent être assignés massivement
    protected $fillable = [
        'user_id',
        'word_id',
        'attempts',
        'is_won',
        'played_on',
        'attempt_state', // État de chaque tentative
        'game_finished' // Indicateur si le jeu est terminé
    ];

    // Si vous stockez les tentatives en tant que JSON, vous pouvez automatiquement les convertir
    protected $casts = [
        'attempts' => 'array'
    ];

    // Relation avec le modèle User (si vous avez un modèle User pour les joueurs)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le modèle MotusWord
    public function motusWord()
    {
        return $this->belongsTo(MotusWord::class, 'word_id');
    }
}
