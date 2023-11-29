<!DOCTYPE html>
<html lang="fr">
@include('commonparts.headtag')

<body class="h-screen bg-motuscolors-back">

{{-- app/resources/views/social/index.blade.php --}}
<!-- Inclusion du Header -->
@include('commonparts.header')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<main class="w-full bg-motuscolors-back flex flex-row">

    <!-- Section des joueurs -->
    <section class="m-8" x-data="{ showAll: false }">
        <div class="container mt-4 mx-auto p-6 bg-motuscolors-text shadow-md rounded border border-[3px] border-motuscolors-darkgray rounded-2xl">
            <div class="flex flex-row justify-between">
                <h1 class="text-3xl mb-4 underline">Liste des joueurs inscrits sur dailymotus</h1>
                <span class="text-4xl mb-4">🎮</span>
            </div>
            <ul class="list-none">
                @foreach($users as $index => $user)
                    <li class="border-b border-motuscolors-back p-3 grid grid-cols-2 lg:grid-cols-3" x-show="showAll || {{$index}} < 5">
                        <div class="hidden lg:flex">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar->path) : asset('default-avatar.png') }}" alt="Avatar" class="h-10 w-10 rounded-full mr-3 object-cover">
                        </div>
                        <div class="flex flex-col flex-start -ml-8 lg:-ml-16 lg:-ml-20">
                            <a href="{{ route('social.profile', $user->id) }}" class="cursor-pointer flex flex-col flex-start hover:bg-gray-100 pl-4 pb-1 rounded-md">
                                <span class="font-medium">{{ $user->name }}</span>
                                <span class="text-gray-600 text-xs">{{ $user->email }}</span>
                            </a>

                        </div>

                        <div class="flex justify-center text-center">
                        <!-- Vérifier si l'utilisateur est déjà un ami -->
                        @if(!$friends->contains($user))
                            @if($friendRequests->contains('sender_id', $user->id))
                                <span class="text-orange-500">Demande reçue</span>
                            @elseif($sentFriendRequests->contains('recipient_id', $user->id))
                                <span class="text-orange-700">Demande envoyée</span>
                            @else
                                <form action="{{ route('add.friend', $user->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    <button type="submit" class="bg-motuscolors-green  text-white py-2 px-4 rounded" >
                                        Ajouter en ami
                                    </button>
                                </form>
                            @endif
                        @else
                            <span class="text-green-500">Déjà ami</span>
                        @endif
                        </div>

                    </li>
                @endforeach
            </ul>
            <div class="w-full flex justify-center">
                <button x-show="!showAll" @click="showAll = true" class="mt-4 text-gray-800 font-bold py-2 px-4 rounded">
                    Voir plus
                </button>
            </div>
        </div>
    </section>


    <!-- Section des amis -->
    <section class="m-8">
        <div class="container mt-4 mx-auto p-6 bg-motuscolors-text shadow-md border border-[3px] border-motuscolors-darkgray rounded-2xl">
            <div class="flex flex-row justify-between">
                <h1 class="text-3xl mb-4 underline">Mes amis </h1>
                <span class="text-4xl font-bold ml-4 mb-4">👬</span>
            </div>
            <ul class="list-none">
                @forelse($friends as $friend)
                    <li class="border-b border-gray-200 p-3 flex justify-between items-center">
                        <div class="flex flex-row flex-start ">
                            <img src="{{ $friend->avatar ? asset('storage/' . $friend->avatar->path) : asset('default-avatar.png') }}" alt="Avatar" class="h-10 w-10 rounded-full mr-3 object-cover">

                            <a href="{{ route('social.profile', $friend->id) }}" class="cursor-pointer flex flex-col flex-start hover:bg-gray-100 pl-2 pb-1 rounded-md">
                                <span class="font-medium">{{ $friend->name }}</span>
                                <span class="text-gray-600 text-xs">{{ $friend->email }}</span>
                            </a>
                        </div>
                    </li>
                @empty
                    <li class="p-3">Aucun ami pour le moment.</li>
                @endforelse
            </ul>
        </div>
    </section>


    <div class="flex flex-col">
        <!-- Section des demandes d'amis reçues -->
        <section class="m-8">
            <div class="container mx-auto p-6 bg-motuscolors-text shadow-md border border-[3px] border-motuscolors-darkgray rounded-2xl">
                <div class="flex flex-row justify-between"><h1 class="text-2xl mb-4 underline">Demandes d'amis reçues </h1><span class="text-2xl font-bold mb-4">📥</span></div>
                <ul class="list-none">
                    @forelse($friendRequests as $request)
                        <li class="border-b border-gray-200 p-3 flex justify-between items-center">
                            <img src="{{ $request->sender->avatar ? asset('storage/' . $request->sender->avatar->path) : asset('default-avatar.png') }}" alt="Avatar" class="h-10 w-10 rounded-full mr-3 object-cover">
                            <div class="flex flex-col mr-6">
                                <span class="font-medium">{{ $request->sender->name }}</span>
                                <span class="text-gray-600 text-xs">{{ $request->sender->email }}</span>
                            </div>
                            <form action="{{ route('accept.friend.request', $request->sender->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                                    Accepter la demande
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="p-3">Aucune demande reçue.</li>
                    @endforelse
                </ul>
            </div>
        </section>

        <!-- Section des demandes d'amis envoyées -->
        <section class="m-8">
            <div class="container mx-auto p-6 bg-motuscolors-text shadow-md border border-[3px] border-motuscolors-darkgray rounded-2xl">
                <div class="flex flex-row justify-between"><h1 class="text-2xl mb-4 underline">Demandes d'amis envoyées </h1><span class="text-2xl font-bold mb-4">↗️</span></div>
                <ul class="list-none">
                    @forelse($sentFriendRequests as $request)
                        <li class="border-b border-gray-200 p-3 flex justify-between items-center">
                            <img src="{{ $request->recipient->avatar ? asset('storage/' . $request->recipient->avatar->path) : asset('default-avatar.png') }}" alt="Avatar" class="h-10 w-10 rounded-full mr-3 object-cover">
                            <div class="flex flex-col justify-start">
                                <span class="font-medium">{{ $request->recipient->name }}</span>
                                <span class="text-gray-600 text-xs">{{ $request->recipient->email }}</span>
                            </div>
                            <!-- Ici, vous pouvez ajouter des actions si nécessaire, comme annuler la demande -->
                        </li>
                    @empty
                        <li class="p-3">Aucune demande envoyée.</li>
                    @endforelse
                </ul>
            </div>
        </section>
    </div>

</main>


<!-- Inclusion du Footer -->
@include('commonparts.footer')

<!-- Scripts JS -->
</body>
</html>
