<x-guest-layout>
    <div class="connexion">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- prenom -->
            <div>
                <x-input-label for="prenom" :value="__('Prénom')" />
                <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- telephone -->
            <div>
                <x-input-label for="telephone" :value="__('Télephone')" />
                <x-text-input id="telephone" class="block mt-1 w-full" type="number" name="telephone" :value="old('telephone')" />
                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            </div>

            <!-- Adresse -->
            <div>
                <x-input-label for="address" :value="__('Adresse')" />
                <textarea id="address" class="block mt-1 w-full" name="address">{{ old('address') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- CP -->
            <div>
                <x-input-label for="code_postal" :value="__('Code postal')" />
                <textarea id="code_postal" class="block mt-1 w-full" name="code_postal">{{ old('code_postal') }}</textarea>
                <x-input-error :messages="$errors->get('code_postal')" class="mt-2" />
            </div>

            <!-- Ville -->
            <div>
                <x-input-label for="ville" :value="__('Ville')" />
                <textarea id="ville" class="block mt-1 w-full" name="ville">{{ old('ville') }}</textarea>
                <x-input-error :messages="$errors->get('ville')" class="mt-2" />
            </div>

            <!-- Date de naissance -->
            <div>
                <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" :value="old('date_naissance')" />
                <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmation mot de passe')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __("S'inscrire") }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
