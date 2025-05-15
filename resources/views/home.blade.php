@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 text-gray-800 dark:text-gray-100">

    {{-- Bienvenue --}}
    <h1 class="text-3xl font-bold mb-6 transition-all duration-300 ease-in-out hover:text-blue-600">
        Bienvenue, {{ Auth::user()->name }} 👋
    </h1>

    {{-- Notifications --}}
    @if ($tachesEnRetard->count() > 0)
        <div class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-4 py-3 rounded mb-6">
            ⚠️ Vous avez {{ $tachesEnRetard->count() }} tâche(s) en retard à traiter immédiatement.
        </div>
    @endif

    {{-- Statistiques rapides --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
            <h2 class="text-lg font-semibold mb-2">Tâches en cours</h2>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $tachesEnCours }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
            <h2 class="text-lg font-semibold mb-2">Tâches terminées</h2>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $tachesTerminees }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
            <h2 class="text-lg font-semibold mb-2">Projets en cours</h2>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $projetsActifs }}</p>
        </div>
    </div>

    {{-- Tâches du jour --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Tâches à faire aujourd’hui</h2>
        @if ($tachesDuJour->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">Aucune tâche prévue pour aujourd’hui.</p>
        @else
            <ul class="space-y-3">
                @foreach ($tachesDuJour as $tache)
                    <li class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-2 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <div>
                            <h3 class="font-medium">{{ $tache->nom }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $tache->description }}</p>
                        </div>
                        <a href="{{ route('taches.show', $tache->id) }}" class="text-blue-500 hover:underline">Voir</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Prochaines échéances --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Prochaines échéances</h2>
        @if ($prochainesTaches->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">Aucune échéance prochaine.</p>
        @else
            <ul class="space-y-3">
                @foreach ($prochainesTaches as $tache)
                    <li class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-2 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <div>
                            <h3 class="font-medium">{{ $tache->nom }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Échéance : {{ \Carbon\Carbon::parse($tache->date_fin)->format('d/m/Y') }}
                            </p>
                        </div>
                        <a href="{{ route('taches.show', $tache->id) }}" class="text-blue-500 hover:underline">Voir</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Actions rapides (admin uniquement) --}}
    @if (Auth::user()->role === 'admin')
    <div class="flex flex-wrap gap-4 justify-start">
        <a href="{{ route('taches.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition-all duration-300 ease-in-out transform hover:scale-105">
            ➕ Créer une tâche
        </a>
        <a href="{{ route('projets.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-purple-700 transition-all duration-300 ease-in-out transform hover:scale-105">
            ➕ Créer un projet
        </a>
        <a href="{{ route('employes.index') }}" class="bg-gray-700 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-gray-800 transition-all duration-300 ease-in-out transform hover:scale-105">
            👥 Gérer les employés
        </a>
    </div>
    @endif

</div>
@endsection
