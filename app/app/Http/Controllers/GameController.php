<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use \Illuminate\View\View;
use App\Models\Game;
use App\Models\Word;
use App\Models\Calendar;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function game(Request $request): View
    {

        // Creation de la session
        $try = session('nbTry', 0);

        $putLetters = $request->input('putLetters');
        $btnValide = $request->input('btnValide');

        // Recuperation du mot
        // $newWord = new Word();
        $goodWord = (new \App\Models\Word)->getRandomWord();
        // $resultat = $newWord->verifWord($putLetters, $goodWord, $try);

        // Creation de la grille
        $game = new Game($goodWord, 8, 8);
        $grid = $game->gameStart();
        //compteur d'essais
        $nbTry = $game->countTry($try, $btnValide);

        $lettersTry = (new \App\Models\Word)->addLetters($putLetters, $nbTry);
        $wordsTry = (new \App\Models\Word)->addWords($putLetters, $nbTry);

        // Data du calendrier
        $dataCalendar = Calendar::getDataCalendar();
        $firstDay = $dataCalendar['firstDay'];
        $daysInMonth = $dataCalendar['daysInMonth'];
        $displayFirstDay = $dataCalendar['displayFirstDay'];

        // Retourne la view game
        return view('game.game', compact('grid',  'nbTry', 'goodWord', 'lettersTry', 'wordsTry', 'displayFirstDay', 'firstDay', 'daysInMonth'));
    }


}
