<section>
    <header>

        <p class="mb-6 text-sm">
            Choisissez un mot de passe sécurisé pour votre compte. Assurez-vous de ne pas l'avoir déjà utilisé sur un autre site.
        </p>
    </header>

    <div class="flex justify-center">
        <form method="post" action="{{ route('password.update') }}" class="-mt-4 space-y-6 w-[60%]">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Mot de passe actuel')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmez le nouveau mot de passe')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-center gap-4">
            <x-primary-button>Valider le mot de passe</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm"
                >Mot de passe modifié ✅</p>
            @endif
        </div>
    </form>
    </div>
</section>
