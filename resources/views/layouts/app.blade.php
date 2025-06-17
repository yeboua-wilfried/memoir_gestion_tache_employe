<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Box Africa Gestion') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script defer src="//unpkg.com/alpinejs" defer></script>

        <link rel="icon" type="image/png" href="{{ asset('images/favicon-96x96.png') }}" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href={{ asset('images/favicon.svg') }} />
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}" />
        <link rel="manifest" href="{{ asset('images/site.webmanifest') }}" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if (in_array(Auth::user()->poste->role, ['admin', 'pdg', 'super_employe', 'super_employe_rh', 'medium_employe', 'super_employe_info']))
            <!-- Page Content -->
            <main class="flex min-h-screen">
                {{-- Nouveau groupe de liens alignés latéralement sous le header --}}
                <div class="flex flex-col w-[200px] min-h-screen bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 py-6 px-4 space-y-4 shadow-md">                    <!-- Liste des employés -->
                    @if(Auth::user()->poste->role === 'admin' || Auth::user()->poste->role === 'super_employe_info' || Auth::user()->poste->role === 'pdg' || Auth::user()->poste->role === 'super_employe_rh')
                        <x-nav-link :href="route('employes.index')" :active="request()->routeIs('employes.index')" class="block px-4 py-2 rounded transition-all"
                            :class="request()->routeIs('employes.index') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-100 dark:hover:bg-gray-700'">
                            {{ __('Liste des employés') }}
                        </x-nav-link>
                    @endif

                    <!-- Toutes les tâches -->
                    <x-nav-link :href="route('taches.index')" :active="request()->routeIs('taches.index')" class="block px-4 py-2 rounded transition-all"
                        :class="request()->routeIs('taches.index') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-100 dark:hover:bg-gray-700'">
                        {{ __('Toutes les tâches') }}
                    </x-nav-link>

                    <!-- Toutes les demandes -->
                    <x-nav-link :href="route('demandes.index')" :active="request()->routeIs('demandes.index')" class="block px-4 py-2 rounded transition-all"
                        :class="request()->routeIs('demandes.index') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-100 dark:hover:bg-gray-700'">
                        {{ __('Toutes les Demandes') }}
                    </x-nav-link>

                    <!-- Tous les postes -->
                    @if(Auth::user()->poste->role === 'admin' || Auth::user()->poste->role === 'super_employe_info' || Auth::user()->poste->role === 'pdg')
                        <x-nav-link :href="route('postes.index')" :active="request()->routeIs('postes.index')" class="block px-4 py-2 rounded transition-all"
                            :class="request()->routeIs('postes.index') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-100 dark:hover:bg-gray-700'">
                            {{ __('Tous les postes') }}
                        </x-nav-link>
                    @endif

                    <!-- Toutes les équipes -->
                    @if(Auth::user()->poste->role === 'admin' || Auth::user()->poste->role === 'super_employe_info' || Auth::user()->poste->role === 'super_employe' || Auth::user()->poste->role === 'super_employe_rh' || Auth::user()->poste->role === 'pdg')
                        <x-nav-link :href="route('equipes.index')" :active="request()->routeIs('equipes.index')" class="block px-4 py-2 rounded transition-all"
                            :class="request()->routeIs('equipes.index') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-100 dark:hover:bg-gray-700'">
                            {{ __('Toutes les équipes') }}
                        </x-nav-link>
                    @endif

                    <!-- Tous les départements -->
                    @if(Auth::user()->poste->role === 'admin' || Auth::user()->poste->role === 'super_employe_info' || Auth::user()->poste->role === 'pdg')
                        <x-nav-link :href="route('departements.index')" :active="request()->routeIs('departements.index')" class="block px-4 py-2 rounded transition-all"
                            :class="request()->routeIs('departements.index') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-100 dark:hover:bg-gray-700'">
                            {{ __('Tous les départements') }}
                        </x-nav-link>
                    @endif
                </div>
                @endif

                @if (isset($slot) && trim($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>

        @livewireScripts
    </body>
</html>
