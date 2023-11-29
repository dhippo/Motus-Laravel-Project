<!DOCTYPE html>
<html lang="fr">
@include('commonparts.headtag')
<body class="bg-motuscolors-back">

<!-- Inclusion du Header -->
@include('commonparts.header')

<!-- Contenu principal -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<main class="bg-motuscolors-back mt-20 py-10">
    @if (session('message'))

        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
    <section class="container mx-auto px-6 text-center">

        <h1 class="text-5xl text-motuscolors-text mb-4">Bienvenue dans le jeu du Motus!</h1>


        <p class="text-motuscolors-darkgray text-lg mb-6">Trouvez le mot du jour en 8 essais maximum.</p>

        <div class="space-x-4 mt-16">
            <a href="/motus/daily" class="bg-motuscolors-green hover:bg-motuscolors-green2 text-white py-4 px-6 rounded text-xl">Jouer au mot du jour</a>
            @auth
            <a href="/motus/archive" class="bg-motuscolors-orange hover:bg-motuscolors-orange2 text-white py-4 px-6 rounded text-xl ">Voir les jours précédents</a>
            @endauth
        </div>
    </section>

</main>

<!-- Inclusion du Footer -->
@include('commonparts.footer')

<!-- Scripts JS -->
</body>
</html>
