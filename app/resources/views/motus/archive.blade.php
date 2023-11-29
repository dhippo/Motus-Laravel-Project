<!DOCTYPE html>
<html lang="fr">
@include('commonparts.headtag')
<body class="bg-motuscolors-back">


<!-- app/resources/views/motus/archive.blade.php -->
<!-- Inclusion du Header -->
@include('commonparts.header')

<!-- Contenu principal -->
<main>
    <section>
        <nav class="w-full pl-20 pt-10">
            <a href="/" class="bg-white rounded-full p-4 border-2 border-gray-800 hover:bg-gray-800 hover:text-white cursor-pointer">
                <span class="mr-6"><</span>
                <span class="text-lg">Accueil</span>
            </a>
        </nav>
    </section>

    <section class="container mx-auto px-6 text-center -mt-10 mb-9">
        <h1 class="text-4xl text-motuscolors-text mb-2 underline cursor-pointer">Liste des anciens mots du mois !</h1>
    </section>

    <section class="w-full flex justify-center">
        <ul class="grid grid-cols-5 w-[55%]">
            @foreach($archivedWords as $word)
                @php
                    $formattedDate = date("d M.", strtotime($word->word_date));                    $game = $word->games->first(); // Récupère le jeu associé à ce mot pour l'utilisateur connecté
                    $score = $game ? (8 - count($game->attempts)) : null;
                @endphp
                <button class="m-2 px-1 py-2 border border-2 border-black bg-white hover:bg-gray-400 text-black rounded-md">
                    <a href="{{ route('motus.play.show', ['date' => $word->word_date]) }}">
                        <div class="text-lg font-bold rounded-full" style="font-weight: 500">
                            <div class="text-red-500 text-base underline">{{ $formattedDate }}</div>

                            <!-- Afficher le mot si le jeu est terminé -->
                            @if($game && $game->game_finished)
                                <div><h5 class="text-sm">{{ strtoupper($game->motusWord->entire_word) }}</h5></div>
                            @else
                                <div><h5 class="text-lg -mb-1">********</h5></div>
                            @endif

                            @if($game)
                                @if($game->game_finished && !$game->is_won)
                                    <div class="text-red-500">Perdu - Jeu Terminé</div>
                                @elseif(!$game->game_finished)
                                    <div class="text-blue-500 -mt-1.5">en cours</div>
                                @elseif($game->game_finished && $game->is_won)
                                    <div class="text-green-500">Gagné</div>
                                @endif
                            @else
                                <div>Jouer</div>
                            @endif
                        </div>
                    </a>
                </button>

            @endforeach


        </ul>
    </section>

</main>

<!-- Inclusion du Footer -->
@include('commonparts.footer')

<!-- Scripts JS -->
</body>
</html>
