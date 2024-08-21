<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Left -->
            <div class="modal-section modal-left">
                <h5 class="text-center mb-3">Pas encore inscrit ?</h5>
                <div class="text-center mb-3">
                    <a href="#" class="btn mt-3">Achat rapide</a>
                </div>
                <div class="text-center">
                    <a href="/register" class="btn mt-3">S'inscrire</a>
                </div>
            </div>
            <!-- Modal Right -->
            <div class="modal-section modal-right d-flex flex-column justify-content-center align-items-center">
                @auth
                <div class="text-center" style="width:360px">
                    <a href="{{ route('recap.show') }}" class="btn mt-3">Voir le récapitulatif</a>
                </div>
            @else
                <h5 class="text-center">Connexion</h5>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Mot de passe')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <input type="hidden" name="redirect_vers_recap" value="true" />
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Se connecter') }}
                        </button>
                    </div>
                </form>
            </div>
            @endauth
        </div>
    </div>
</div>