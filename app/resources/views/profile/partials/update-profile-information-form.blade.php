@vite(['resources/css/app.css', 'resources/js/app.js'])
<section>
    <header>

        <p class="mb-2 text-sm hidden lg:block rounded-md p-1">
            Mettez à jour les informations de votre nom de profil et votre adresse e-mail.
        </p>
    </header>


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="w-full -mt-9 flex justify-center">
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 w-[70%]">
        @csrf
        @method('patch')


        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full autofocus" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

        </div>

        <div class="flex justify-center gap-4">
            <x-primary-button>Valider les informations</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm"
                >Informations modifiées ✅</p>
            @endif
        </div>
    </form>
    </div>
</section>
