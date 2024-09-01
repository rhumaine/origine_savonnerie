@section('title',  'Dashboard admin')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-column flex-md-row" style="min-height: 50vh;">
            <!-- Sidebar -->
            <div class="sidebarDashboard bg-white p-4 rounded-lg shadow flex-shrink-0">
                <ul class="space-y-4">
                    <li>
                        <a href="#" onclick="showSection('profile')" class="block font-semibold text-gray-800 dark:text-gray-200 hover:text-blue-500">
                            Mon profil
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="showSection('orders')" class="block font-semibold text-gray-800 dark:text-gray-200 hover:text-blue-500">
                            Listes des commandes
                        </a>
                    </li>
                    <li>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">{{ __('Se déconnecter') }}</a>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Content -->
            <div class="p-4 sm:p-8 bg-white contentDashboard shadow rounded-lg">
                <!-- Profile Section -->
                <div id="profile">
                   
                    <div class="bg-white ">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
        
                    <div class="bg-white dark:bg-gray-800 sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>                    
                </div>

                <!-- Orders Section -->
                <div id="orders" class="hidden">
                    <div class="max-w-xl">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                            Liste des commandes
                        </h3>
                        
                        @foreach ($commandes as $c)
                            <div class="containerCommande">
                    
                                <div class="content">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $c->titre }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $c->description }}</p>
                                    
        
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-300">
                                            Nom : {{ $c->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-300">
                                            Date de commande : {{ $c->created_at->format('d/m/Y') }}
                                        </p>

                                        @php
                                            $historique = is_string($c->historique_statuts) ? json_decode($c->historique_statuts, true) : $c->historique_statuts;
                                            $dernierStatut = !empty($historique) ? end($historique)['statut'] : 'Aucun statut disponible';
                                        @endphp
                                        <p class="text-sm text-gray-500 dark:text-gray-300">
                                            Statut : <span id="statusDisplay-{{ $c->id }}" class="font-semibold">{{ $dernierStatut }}</span>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-300">
                                            Prix : {{ number_format($c->total, 2) }} €
                                        </p>
                                    </div>
                                </div>
                                    
                                <div class="buttonContainer">
                                    <a href="{{ route('commandes.show', $c->id) }}" class="btnDetail px-4 py-2 rounded-md">
                                        Voir les détails
                                    </a>
                                    <a href="#" class="btnAction px-4 py-2 rounded-md" data-status="Archivé" data-id="{{ $c->id }}">
                                        Archiver
                                    </a>
                                    <a href="#" class="btnAction px-4 py-2 rounded-md" data-status="Expédié" data-id="{{ $c->id }}">
                                        Expédier
                                    </a>
                                </div>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.getElementById('profile').classList.add('hidden');
            document.getElementById('orders').classList.add('hidden');
            
            // Show the selected section
            document.getElementById(sectionId).classList.remove('hidden');
        }

        // Show profile by default
        showSection('orders');
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionne tous les liens avec la classe 'btnDetail'
            document.querySelectorAll('.btnAction').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Empêche le comportement par défaut du lien
                    
                    const status = button.getAttribute('data-status');
                    const commandeId = button.getAttribute('data-id');

                    fetch(`/admin/commande/update-status/${commandeId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ statut: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('statusDisplay-'+commandeId).textContent = status;
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

</x-app-layout>
