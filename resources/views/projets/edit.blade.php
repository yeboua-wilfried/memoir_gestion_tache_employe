@extends('layouts.app')

@section('content')
<div class="w-[80%] mx-auto px-6 py-10 bg-white dark:bg-gray-900 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-8">Modifier le projet</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <strong>Des erreurs sont survenues :</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projets.update', $projet->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom du projet</label>
            <input type="text" name="nom" value="{{ old('nom', $projet->nom) }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" required rows="4" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">{{ old('description', $projet->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début</label>
                <input type="date" name="date_debut" value="{{ old('date_debut', $projet->date_debut) }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin</label>
                <input type="date" name="date_fin" value="{{ old('date_fin', $projet->date_fin) }}" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
            </div>
        </div>

        <hr class="my-6 border-gray-300 dark:border-gray-700">

        <div>
            <button type="button" id="toggleTaches" class="text-indigo-600 hover:underline dark:text-indigo-400">Modifier les tâches</button>
        </div>

        <div id="tacheSection">
            <div id="tacheContainer" class="flex flex-wrap gap-6 justify-center">
                @foreach ($projet->taches as $index => $tache)
                    <div class="tacheItem w-full md:w-[30%] border p-4 rounded-lg dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Tâche</h4>

                        <input type="hidden" name="taches[{{ $index }}][id]" value="{{ $tache->id }}">

                        <div class="mt-4 text-right">
                            <button type="button" class="deleteTache bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Supprimer cette tâche</button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text" name="taches[{{ $index }}][nom]" value="{{ $tache->nom }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date début</label>
                                <input type="date" name="taches[{{ $index }}][date_debut]" value="{{ $tache->date_debut }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date fin</label>
                                <input type="date" name="taches[{{ $index }}][date_fin]" value="{{ $tache->date_fin }}" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="taches[{{ $index }}][description]" rows="3" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">{{ $tache->description }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigner à</label>
                            <div class="max-h-40 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md p-2 space-y-1 bg-white dark:bg-gray-800">
                                @foreach($users as $user)
                                @php
                                    $tachesCount = $user->tache_realiser_users_count;
                                    $assigned = $tache->tacheRealiserUsers->contains($user->id);
                                @endphp

                                    <label class="flex items-center justify-between px-3 mb-2 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox" name="taches[{{ $index }}][users][]" value="{{ $user->id }}"
                                                {{ $assigned ? 'checked' : '' }}
                                                class="w-5 h-5 text-blue-600 rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-blue-500">
                                            <span class="text-gray-800 dark:text-white font-medium">
                                                {{ $user->name }} {{ $user->prenom }}
                                            </span>
                                        </div>
                                        <span class="text-sm font-semibold px-3 py-1 rounded-full
                                            {{ $tachesCount >= 3 ? 'bg-red-100 text-red-700' : ($tachesCount == 2 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                            {{ $tachesCount }} tâche{{ $tachesCount > 1 ? 's' : '' }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center mt-4">
                <button type="button" id="addTache" class="text-indigo-600 hover:underline dark:text-indigo-400">Ajouter une autre tâche</button>
            </div>
        </div>

        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Mettre à jour le projet</button>
        </div>
    </form>
</div>

@vite(['resources/js/afficheSousTache.js'])
@endsection
