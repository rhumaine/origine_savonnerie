<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Logo à gauche -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="img-fluid" style="height: 60px; width: auto;">
            </a>

            <!-- Bouton de basculement pour les petits écrans -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu centré -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="w-100 d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                    <!-- Menu principal -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/a-propos') }}">Qui sommes-nous</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                        </li>
                    </ul>
                    
                    <!-- Connexion et inscription -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                        <li class="nav-item">
                            <a class="nav-link d-inline-flex align-items-center position-relative p-0" href="{{ route('panier.show') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalProduits > 0 ? $totalProduits : '0' }}
                                </span>
                            </a>
                        </li>
                        
                        
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    @if(auth()->user()->role === 'admin')
                                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    @else
                                        <a class="nav-link" href="{{ route('dashboard') }}">Mon compte</a>
                                    @endif
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                                </li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
