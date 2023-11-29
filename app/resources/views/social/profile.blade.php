<!DOCTYPE html>
<html lang="fr">
@include('commonparts.headtag')
<body class="bg-motuscolors-back text-motuscolors-text">

<!-- app/resources/views/social/profile.blade.php -->
<!-- Inclusion du Header -->
@include('commonparts.header')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<main>
    <div class="container mx-auto p-6">
        <!-- Head Section Profil de l'Utilisateur -->
        <div class="flex items-center justify-center flex-col sm:flex-row p-6 ">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar->path) : asset('default-avatar.png') }}"
                 alt="Avatar"
                 class="h-32 w-32 rounded-full object-cover border-4 border-motuscolors-orange mb-4 sm:mb-0 sm:mr-8">
            <div>
                <h2 class="text-4xl text-motuscolors-red mb-1">{{ $user->name }}</h2>
                <h3 class="text-lg mb-3">{{ $user->email }}</h3>
                <!-- Ajouter d'autres informations pertinentes ici si nécessaire -->
            </div>
        </div>


        <!-- Body Section Historique des Jeux -->
        <div class="flex flex-row w-full">
            <!-- Section Rapport de Joueur -->
            <div class="w-1/2 p-4">
                <div class="w-full p-3 rounded-md" style="box-shadow: rgb(176, 177, 175) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;">
                    <h3 class="text-3xl mb-4 underline">Rapport du joueur</h3>

                </div>
            </div>
            <!-- Section Détails des Parties -->
            <div class="w-1/2 p-4">
                <div class="rounded-md w-full p-4" style="box-shadow: rgb(176, 177, 175) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;"">
                    <h3 class="text-3xl mb-8 underline">Détails des parties</h3>
                <ul class="list-disc pl-5">
                    @forelse($games as $game)
                        <li class="mb-4 border-b-2 border-motuscolors-darkgray">
                            <div class="w-[30%] flex flex-row justify-between">
                                <span>{{ $game->motusWord->word_date->format('d M Y') }}:</span>
                                <span class="{{ $game->is_won ? 'text-motuscolors-green' : 'text-motuscolors-red' }}">
                                        {{ $game->is_won ? 'Gagné' : 'Perdu' }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li>Pas de jeux joués pour le moment.</li>
                    @endforelse
                </ul>
                </div>
            </div>
        </div>
    </div>
</main>




<!-- Inclusion du Footer -->
@include('commonparts.footer')

<!-- Scripts JS -->
</body>
</html>
