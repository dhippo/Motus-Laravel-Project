<!DOCTYPE html>
<html lang="fr">
@include('commonparts.headtag')

<body class="h-screen bg-motuscolors-back">

{{-- app/resources/views/motus/play.blade.php --}}
@include('commonparts.header')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<main class="bg-motuscolors-back py-5" >


    <div class="w-full flex flex-col sm:flex-row">
        {{-- Section Gauche --}}
        <section id="on-left" class="w-1/2">

            <section>
                <nav class="w-full pl-20 pt-10 pb-5">
                    <a href="/motus/archive" class="bg-white rounded-full p-4 border-2 border-gray-800 hover:bg-gray-800 hover:text-white cursor-pointer">
                        <span class="mr-6"><</span>
                        <span class="text-lg">Mots précédents</span>
                    </a>
                </nav>
            </section>


            <div id="titleGame" class="w-full flex flex-col items-center justify-center">
                @php
                    $formattedDate = strftime("%A %d %B %Y", strtotime($archiveDate));
                @endphp
                <h2 class="text-xl text-white p-4 ml-48 cursor-pointer ">Le mot du {{ $formattedDate }}</h2>

            @if ($gameFinished)
                    <!-- Fenetre PARTIE TERMINÉE -->
                    <div class="text-center bg-white border-2 mb-4 border-gray-800 w-[30rem] h-[15rem] rounded-md opacity-80">
                        <div class="h-full flex flex-col justify-center items-center px-4 py-10">

                            @if ($isWon)
                                <p class="text-4xl mb-4">BRAVO</p>
                                <p class="text-4xl mb-4">Vous avez réussi à trouver le mot ! 🎉</p>
                                @php
                                    $score = 8 - $nbTry;
                                @endphp
                                <p class="text-3xl">Votre score : {{ $score }} sur 8</p>
                            @else
                                <h1 class="text-3xl mb-4">Le mot à trouver était </h1>
                                <h1 class="text-3xl mb-4 text-red-600 tracking-[1.1rem]">{{strtoupper($goodWord)}}</h1>
                                <p class="text-4xl mb-4">Vous avez perdu ! 😔</p>
                                <p class="text-3xl">Vous n'avez pas trouvé le mot avant les 8 tentatives 😩</p>
                            @endif

                        </div>
                    </div>
                @else
                    <h1 class="text-8xl font-bold text-white p-4 cursor-pointer mb-6"><span class="text-motuscolors-red">Jeu</span> <span class="text-motuscolors-orange">du</span> <span class="text-motuscolors-green">Motus</span></h1>
                @endif



            </div>

            <div id="infoGame" class="flex w-full justify-center">
                <div class="flex text-lg flex-col rounded-md px-9 py-3 items-center bg-motuscolors-darkgray cursor-pointer border-2 border-white hover:border-gray-800">
                    {{-- Informations du Jeu --}}
                    <p id="nbTry">Nombre d'essai : {{ $nbTry }}</p>
                    <p id="lettersT" class="mt-2">Lettres testées : {{ implode(', ', $lettersTry) }}</p>
                    <p id="wordsT" class="mt-2">Mots testés : {{ strtoupper(implode(', ', $wordsTry)) }}</p>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Section Droite --}}
        <section id="on-right" class="sm:w-1/2">
            {{-- app/resources/views/motus/play.blade.php --}}
            <div id="motusGame" x-data>
                <form method="POST" action="{{ route('motus.play.attempt', ['date' => $archiveDate]) }}" class="-mt-6 flex flex-row items-center">
                    @csrf
                    <div id="grid" class="flex flex-col items-center rounded-2xl m-4 p-4" style="background-color: #363736">
                        @foreach ($grid as $line => $row)
                            <div class="flex justify-center my-1">
                                @foreach ($row as $key => $inputLetter)
                                    <input
                                        type="text"
                                        name="putLetters[{{ $line }}][{{ $key }}]"
                                        maxlength="1"
                                        pattern="[A-Za-z]+"
                                        class=" text-center placeholder-motuscolors-back w-14 h-14 border rounded uppercase p-2 text-2xl rounded-full m-1
                                        @if (is_string($inputLetter) && strtoupper($inputLetter) === strtoupper($goodWord[$key])) bg-motuscolors-green text-white
                                        @elseif (is_string($inputLetter) && in_array(strtoupper($inputLetter), str_split(strtoupper($goodWord)))) bg-motuscolors-orange text-white
                @elseif (is_string($inputLetter) && !empty($inputLetter) && !in_array(strtoupper($inputLetter), str_split(strtoupper($goodWord)))) bg-motuscolors-red text-white
                                        @endif"
                                        value="{{ $inputLetter }}"
                                        x-ref="input{{ $line }}{{ $key }}"
                                        x-on:input="handleInput($refs, {{ $line }}, {{ $key }}, {{ $wordLength }})"
                                        @if ($gameFinished || $nbTry != $line) disabled @endif
                                        required>
                                @endforeach
                            </div>
                        @endforeach


                    </div>
                    {{-- Afficher le bouton de soumission seulement si le jeu n'est pas terminé --}}
                    @if (!$gameFinished)
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-9 text-xl text-white rounded-full bg-motuscolors-green">Valider</button>
                        </div>
                    @endif
                </form>
            </div>
        </section>

    </div>



</main>

<script>
    function handleInput(refs, line, key, wordLength) {
        if (key < wordLength - 1) {
            refs[`input${line}${key + 1}`].focus();
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.start();
        setTimeout(() => {
            document.querySelector('[x-ref="input00"]').focus();
        }, 300);
    });
</script>


<!-- Inclusion du Footer -->
@include('commonparts.footer')

<!-- Scripts JS -->
</body>
</html>
