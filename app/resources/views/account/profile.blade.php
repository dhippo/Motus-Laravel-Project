<!DOCTYPE html>
<html lang="fr">
@include('commonparts.headtag')

<body style="background-color: #363736; color: #ededeb">

<!-- app/resources/views/account/profile.blade.php-->
<!-- Inclusion du Header -->
@include('commonparts.header')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<main class="p-2">
    <div class="w-full flex flex-row justify-center items-center mt-8 sm:mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <h1 class="text-5xl mx-3">Réglages</h1>

    </div>

    <div class="flex flex-col sm:flex-row pt-6 pb-10 mx-10">
        <section id="update_name_email" class="border-t mt-6 sm:mt-0 sm:border-t-[0px] sm:w-1/2">
            <div class="flex flex-col justify-center items-center">
                <h2 class="text-4xl -mb-2 lg:mb-4 pt-4 pl-4 pr-4 cursor-pointer text-center border-b-[3px] border-motuscolors-orange">Modifier mon nom et mon email</h2>
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>
        <section id="edit_avatar" class="mx-8 border-t mt-6 sm:mt-0 sm:border-t-[0px] sm:w-1/2 sm:border-l">
            <div class="w-full mx-2 flex flex-col items-center justify-center">
                <h2 class="text-4xl cursor-pointer pt-4 pl-4 pr-4 text-center border-b-[3px] border-motuscolors-red">Modifier mon avatar</h2>
            </div>
            <div class="mx-16 mt-4">
                <p class="mb-6 text-sm text-center">
                    Personnalisez votre compte en téléchargeant un nouvel avatar. Assurez-vous qu'il respecte notre <u>Politique de contenu</u>.
                </p>
            </div>
            <div class="mt-7 mb-4">
                <form action="{{ route('account.upload-avatar') }}" method="POST" enctype="multipart/form-data" class=" flex flex-col justify-center items-center">
                    @csrf
                    {{-- Afficher la photo de profil --}}
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar->path) }}" alt="Photo de profil" class="rounded-full h-24 w-24 object-cover">
                    @else
                        <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" class="rounded-full h-24 w-24 object-cover">
                    @endif
                    <div class="w-full flex justify-center mt-2 pl-16"><input type="file" name="avatar" required></div>

                    <div class="mt-6">
                    <x-primary-button>Valider l'image de profil</x-primary-button>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <section id="update_password" class="border-t border-b py-10 mx-10 ">
        <div class="flex flex-col justify-center items-center">
            <h2 class="text-4xl pt-2 mb-8 cursor-pointer border-b-[3px] border-motuscolors-back400 px-4">Modifier mon mot de passe</h2>
            @include('profile.partials.update-password-form')
        </div>
    </section>

    <section id="delete_account" class="w-full flex flex-col items-center my-8">
        <h2 class="text-4xl pt-2 pb-8 rounded-lg cursor-pointer">Supprimer mon compte</h2>
        <div class="mx-16 mt-4">
            <p class="mb-6 text-sm text-center">Toute suppresssion est définitive</p>
        </div>
        @include('profile.partials.delete-user-form')
    </section>



</main>


<!-- Inclusion du Footer -->
@include('commonparts.footer')

<!-- Scripts JS -->
</body>
</html>
