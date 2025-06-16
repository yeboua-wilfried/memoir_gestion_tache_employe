@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">🗂️ Mes Tâches et Projets</h1>

    @php
        $enCours = $taches->where('etat', 'en cours');
        $terminees = $taches->where('etat', 'terminee');
    @endphp

    @if($taches->isEmpty())
        <p class="text-gray-600 dark:text-gray-300">Vous n'avez encore aucune tâche ou projet enregistré.</p>
    @else

        {{-- Tâches en cours --}}
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-yellow-600 dark:text-yellow-400 mb-4">📌 Tâches en cours</h2>
            @if($enCours->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Aucune tâche en cours.</p>
            @else
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($enCours as $tache)
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $tache->nom }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                    {{ Str::limit($tache->description, 100) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    📅 Date limite : <span class="font-medium">{{ \Carbon\Carbon::parse($tache->date_fin)->format('d M Y') }}</span>
                                </p>
                                <p class="text-sm mb-4 text-gray-500 dark:text-white">
                                    🔖 Statut :
                                    <span class="inline-block px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                        {{ $tache->etat }}
                                    </span>
                                </p>
                                <a href="{{ route('taches.show', $tache->id) }}"
                                    class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tâches terminées --}}
        <div>
            <h2 class="text-2xl font-semibold text-green-600 dark:text-green-400 mb-4">✅ Tâches terminées</h2>
            @if($terminees->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Aucune tâche terminée.</p>
            @else
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($terminees as $tache)
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $tache->nom }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                    {{ Str::limit($tache->description, 100) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    📅 Date limite : <span class="font-medium">{{ \Carbon\Carbon::parse($tache->date_fin)->format('d M Y') }}</span>
                                </p>
                                <p class="text-sm mb-4 text-gray-500 dark:text-white">
                                    🔖 Statut :
                                    <span class="inline-block px-2 py-1 rounded-full bg-green-100 text-green-700">
                                        {{ $tache->etat }}
                                    </span>
                                </p>
                                <a href="{{ route('taches.show', $tache->id) }}"
                                    class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @endif
</div>
@endsection
