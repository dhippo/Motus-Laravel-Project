<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Game
{
    private array $grid;
    private array $word;


    public function __construct($word, $nbLine, $nbCln)
    {
        // On recupere ici la grille
        $gridBuilder = new buildGrid( $nbLine, $nbCln);
        $grid = $gridBuilder->BuildGrid();

        $this->grid = $grid;
        $this->word = $word;


    }

    // Fonction qui compte l[e nombre d'essais
    public function countTry($nbTry, $btnValide): int {

        // 8 est le nombre d'essai max alors remettre à 0, sinon lui ajouter 1
        if ( isset($btnValide) ) {
            if ( $nbTry == 7 ) {
                session(['nbTry' => 0]);
                Session::forget('listLetters');
                Session::forget('listWords');

            } else{
                $nbTry++;
                session(['nbTry' => $nbTry]);
            }
        }else {
            session(['nbTry' => 0]);
        }


        return session('nbTry');
    }

    public function gameStart(): array {

        // Générer la grille venant de la class BuildGrid
        $grid = $this->grid;

        // Recupere la premiere lettre du mot
        $word=$this->word;
        $firstLetter = $word[0];

        //pour chaque 1ere colonne de chaque lignes
        for ( $i = 0; $i < count($grid); $i++ ) {
                //ajouter la premiere lettre à la premiere colonne
                $grid[$i][0] = "$firstLetter";

        }

        return $grid;
    }


}
