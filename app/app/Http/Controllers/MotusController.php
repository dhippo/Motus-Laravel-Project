<?php

namespace App\Http\Controllers;

use App\Models\MotusGame;
use Illuminate\Http\Request;
use App\Models\MotusWord;
use Illuminate\Support\Facades\Http;


// app/app/Http/Controllers/MotusController.php
class MotusController extends Controller
{
    public function showDailyGame()
    {
        $today = date('Y-m-d');
        $dailyWord = MotusWord::where('word_date', $today)->first();
        $user_id = auth()->id(); // On récupère l'ID de l'utilisateur connecté, logique.
        if (is_null($user_id)) {
            return redirect()->route('login')->with('status', 'Vous devez être connecté pour jouer mot du jour.');
        }

        if (!$dailyWord) {
            // Aucun mot pour aujourd'hui, donc on en génère un.
            $this->generateDailyWordIfNeeded();
        }

        // Rediriger vers la route du jeu avec le mot du jour.
        return redirect()->route('motus.play.show', ['date' => $today]);
    }

    public function generateDailyWordIfNeeded()
    {
        $today = date('Y-m-d');
        $dailyWord = MotusWord::where('word_date', $today)->first();

        if (!$dailyWord) {
            $randomWord = $this->fetchRandomWord();
            if ($randomWord) {
                MotusWord::create([
                    'entire_word' => $randomWord,
                    'word_date' => $today
                ]);
            } else {
                // Gérer le cas où l'API ne renvoie pas de mot
                return 'Impossible de récupérer un mot aléatoire';
            }
        }

        return $randomWord ?? $dailyWord->entire_word;
    }

    public function fetchRandomWord()
    {
        $isValid = false;
        $tries = 0;
        $maxTries = 10;

        while (!$isValid && $tries < $maxTries) {
            $response = Http::get('https://trouve-mot.fr/api/size/8');
            if ($response->successful()) {
                $wordData = $response->json();
                $word = $wordData[0]['name'] ?? null;

                // Vérification si le mot contient uniquement des lettres A-Z (sans accent)
                if ($word && preg_match('/^[A-Z]+$/i', $word)) {
                    $isValid = true;
                    return $word;
                }
            }
            $tries++;
        }

        return null;
    }

    public function generateWordsForCurrentMonth()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Parcourir chaque jour du mois
        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $formattedDate = $date->toDateString();

            // Vérifier si un mot existe déjà pour ce jour
            if (!MotusWord::where('word_date', $formattedDate)->exists()) {
                // S'il n'y a pas de mot pour ce jour, en générer un
                $randomWord = $this->fetchRandomWord();

                // Si un mot valide est récupéré, l'ajouter à la base de données
                if ($randomWord) {
                    MotusWord::create([
                        'entire_word' => $randomWord,
                        'word_date' => $formattedDate
                    ]);
                }
            }
        }
    }

    public function showArchives()
    {
        $user_id = auth()->id();
        if (is_null($user_id)) {
            return redirect()->route('login')->with('status', 'Vous devez être connecté pour jouer.');
        }
        $this->generateWordsForCurrentMonth();
        $startOfMonth = now()->startOfMonth()->toDateString(); // Début du mois en cours
        $today = now()->toDateString(); // Date actuelle

        $archivedWords = MotusWord::whereBetween('word_date', [$startOfMonth, $today])
            ->orderBy('word_date', 'desc')
            ->with(['games' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }])
            ->get();

        return view('motus.archive', ['archivedWords' => $archivedWords]);
    }


    private function initializeGrid($goodWord)
    {
        $grid = [];
        $wordLength = strlen($goodWord);

        for ($i = 0; $i < 8; $i++) {
            $grid[$i] = array_fill(0, $wordLength, '');
        }

        return $grid;
    }

// app/app/Http/Controllers/MotusController.php
    public function showGameByDate($date)
    {
        $user_id = auth()->id(); // On récupère l'ID de l'utilisateur connecté, logique.
        if (is_null($user_id)) {
            return redirect()->route('login')->with('status', 'Vous devez être connecté pour jouer au motus .');
        }

        $motusGame = MotusGame::where('user_id', $user_id)
            ->whereHas('motusWord', function ($query) use ($date) {
                $query->where('word_date', $date);
            })
            ->first(); // Là, on cherche dans la base si t'as déjà joué à ce jeu à cette date.

        $isWon = false;

        if (!$motusGame) {
            // Si t'as pas encore joué à cette date, on prépare un nouveau jeu.
            $dailyWord = MotusWord::where('word_date', $date)->first();
            if (!$dailyWord) {
                // Si on trouve pas le mot du jour pour cette date, on te renvoie en arrière.
                return redirect()->back()->with('status', 'Aucun mot trouvé pour cette date.');
            }

            // Ici, on prépare le jeu avec le mot du jour et une grille toute neuve.
            $goodWord = $dailyWord->entire_word;
            $wordLength = strlen($goodWord);
            $grid = $this->initializeGrid($goodWord);
            $gameFinished = false; // Le jeu commence, alors forcément, il n'est pas fini.
            $nbTry = 0; // Tu n'as pas encore essayé, donc le compteur d'essais est à zéro.
            $lettersTry = []; // Liste vide des lettres essayées, car t'as pas encore commencé.
            $wordsTry = []; // Pareil pour les mots essayés.
        } else {

            // Si t'as déjà joué à cette date, on charge la partie où tu t'es arrêté.
            $goodWord = $motusGame->motusWord->entire_word;
            $wordLength = strlen($goodWord);
            $grid = $this->initializeGrid($goodWord); // On initialise la grille avec 8 lignes vides.

            // Maintenant, on remplit la grille avec tes tentatives déjà faites.
            foreach ($motusGame->attempts as $attemptIndex => $attempt) {
                $grid[$attemptIndex] = $attempt;
            }

            $gameFinished = $motusGame->game_finished;
            $nbTry = count($motusGame->attempts); // On compte combien de fois t'as essayé.
            $lettersTry = collect($motusGame->attempts)->flatten()->filter()->unique()->toArray(); // On récupère toutes les lettres que t'as déjà essayées.
            $wordsTry = array_map(function ($row) use ($wordLength) {
                if (is_array($row[0])) {
                    $row = array_reduce($row, 'array_merge', []);
                }
                return implode('', array_slice($row, 0, $wordLength));
            }, $motusGame->attempts);

            $isWon = $motusGame->is_won;
        }

        // On formate la date pour l'afficher joli-joli dans la vue.
        $formattedDate = strftime("%A %d %B %Y", strtotime($date));
        $archiveDate = $date; // On garde la date du jeu pour la passer à la vue.

        // Et là, bam ! On envoie tout ça à la vue pour que tu puisses jouer.
        return view('motus.play', compact('formattedDate', 'goodWord', 'gameFinished', 'nbTry', 'lettersTry', 'wordsTry', 'grid', 'archiveDate', 'isWon', 'wordLength'));
    }

    public function attemptGameByDate(Request $request, $date)
    {
        $user_id = auth()->id(); // Encore une fois, on choppe ton ID pour savoir que c'est toi.
        if(is_null($user_id)){
            return redirect()->route('login');
        }

        $motusWord = MotusWord::where('word_date', $date)->first();
        if (!$motusWord) {
            // Si on trouve pas le mot pour cette date, retour à la case départ.
            return redirect()->back()->with('status', 'Mot non trouvé pour cette date.');
        }

        // On crée une nouvelle partie ou on en charge une existante.
        $motusGame = MotusGame::firstOrCreate([
            'user_id' => $user_id,
            'word_id' => $motusWord->id
        ], [
            'attempts' => [],
            'is_won' => false,
            'played_on' => now() // On note quand tu joues.
        ]);

        // Ici, on prend les lettres que t'as entrées et on les ajoute à tes tentatives.
        $inputLetters = $request->input('putLetters');
        $flattenedInputLetters = array_reduce($inputLetters, 'array_merge', []);

        $currentAttempts = $motusGame->attempts;
        $currentAttempts[] = $flattenedInputLetters;
        $motusGame->attempts = $currentAttempts; // On enregistre tes tentatives.

        // Vérifie si l'utilisateur a gagné
        if (implode('', $flattenedInputLetters) === $motusWord->entire_word) {
            $motusGame->is_won = true;
            $motusGame->game_finished = true;
        } elseif (count($currentAttempts) >= 8) { // Vérifie si le nombre maximal de tentatives est atteint
            $motusGame->game_finished = true;
        }


        $motusGame->save(); // Et on sauvegarde le tout.

        // Si tes lettres forment le bon mot, t'as gagné !
        if (implode('', $flattenedInputLetters) === $motusWord->entire_word) {
            $motusGame->is_won = true; // Gagné !
            $motusGame->save(); // On sauvegarde ta victoire.

            // On te redirige avec un message de félicitations.
            return redirect()->route('motus.play.show', ['date' => $date])->with('status', 'Félicitations, vous avez gagné!');
        }

        // Si t'as pas encore gagné, on te renvoie pour que tu continues à jouer.
        return redirect()->route('motus.play.show', ['date' => $date]);
    }

}
