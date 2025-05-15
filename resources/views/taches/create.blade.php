@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Créer une tâche</h2>

    <form action="{{ route('taches.store') }}" method="POST" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
            <input type="text" name="nom" id="nom" required
                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" id="description" rows="3" required
                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" required
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm">
            </div>

            <div>
                <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin" required
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm">
            </div>
        </div>

        <div>
            <label for="type_tache_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de tâche</label>
            <select name="type_tache_id" id="type_tache_id"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm">
                @foreach($typesTache as $type)
                    <option value="{{ $type->id }}">{{ $type->nom }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <!-- Sous-formulaire pour sous-tâches (affiché si type_tache_id == 2) -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Ajouter une ou plusieurs sous-tâches</h3>

            <div id="sousTacheContainer">
                <div class="sousTacheItem space-y-4 border p-4 rounded-md bg-gray-50 dark:bg-gray-700 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                        <input type="text" name="sous_taches[0][nom]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="sous_taches[0][description]" rows="2" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date début</label>
                            <input type="date" name="sous_taches[0][date_debut]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date fin</label>
                            <input type="date" name="sous_taches[0][date_fin]" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="addSousTache"
                    class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                + Ajouter une autre sous-tâche
            </button>
        </div>

        <div>
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@vite(['resources/js/afficheSousTache.js'])

@endsection
