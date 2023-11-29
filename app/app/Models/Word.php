<?php

namespace App\Models;

class Word
{
    // Liste qui contient tous les mots
    private array $listWords;

    public function __construct()
    {
        $this->listWords = [
            "Bonheurs",
            "Chocolat",
            "Distance",
            "Ensemble",
            "Festival",
            "Gourmand",
            "Imprimer",
            "Jardinier",
            "Lumineux",
            "Mystérieux"
        ];

    }

    public function getRandomWord(): array
    {
        // Selct un mot aleatoire de la liste
        $randomIndex = rand(0, count($this->listWords) - 1);

        // return $this->listWors[$randomIndex];

        return str_split(strtoupper("imprimer"));
    }

    public function addLetters($putLetters, $nbTry): array
    {

        // Liste qui contient toutes les lettres essayé,
        // si elle la variable session n'existe pas alors un tableau vide est crée
        $listLetters = session('listLetters', []);

        // Si la variable $putLetters existe alors on ajoute las lettre dans la liste
        // sinon crée un tableau vide de lettre

        if ($nbTry > 0) {
            foreach($putLetters as $putLetter){
                if (!in_array(strtoupper($putLetter), $listLetters)) {
                    array_push($listLetters, strtoupper($putLetter));
                }

            }
            session(['listLetters' => $listLetters]);
        } else {
            $listLetters[] = '';
            session(['listLetters' => $listLetters]);

        }

        return session('listLetters');
    }

    public function addWords($putWords,$nbTry): array
    {
        $listWords = session('listWords', []);

        if ($nbTry > 0) {
            $listWords[$nbTry-1] =  strtoupper(join('',$putWords));

            session(['listWords' => $listWords]);

        } else {
//            $listWords = array_fill(0, 7, '');;
            session(['listWords' => []]);
        }


        return session('listWords');
    }

    public function verifWord($putWords, $goodWord, $nbTry): bool
    {


        if ($putWords === join('',$goodWord)) {
            return true;
        } else {
            return false;
        }

    }

}
