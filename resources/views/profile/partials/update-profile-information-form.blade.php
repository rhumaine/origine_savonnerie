<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- prenom -->
        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom', $user->prenom)" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

         <!-- telephone -->
         <div>
            <x-input-label for="telephone" :value="__('Télephone')" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" pattern="^\+?[0-9\s\-\(\)]*$" :value="old('telephone', $user->telephone)" title="Veuillez entrer un numéro de téléphone valide" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <!-- Adresse -->
        <div>
            <x-input-label for="address" :value="__('Adresse')" />
            <textarea id="address" class="block mt-1 w-full" name="address">{{ old('address', $user->address) }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- CP -->
        <div>
            <x-input-label for="code_postal" :value="__('Code postal')" />
            <x-text-input id="code_postal" class="block mt-1 w-full" name="code_postal" :value="old('code_postal', $user->code_postal)" />
            <x-input-error :messages="$errors->get('code_postal')" class="mt-2" />
        </div>

        <!-- Ville -->
        <div>
            <x-input-label for="ville" :value="__('Ville')" />
            <x-text-input id="ville" class="block mt-1 w-full" name="ville":value="old('code_postal', $user->ville)" />
            <x-input-error :messages="$errors->get('ville')" class="mt-2" />
        </div>
        
        <!-- Date de naissance -->
        <div>
            <x-input-label for="date_naissance" :value="__('Date de naissance')" />
            <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" :value="old('date_naissance', $user->date_naissance)" />
            <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
