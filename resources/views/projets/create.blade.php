@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white dark:bg-gray-900 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-8">Créer un projet</h2>

    <form action="{{ route('projets.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom du projet</label>
            <input type="text" name="nom" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" required rows="4" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début</label>
                <input type="date" name="date_debut" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin</label>
                <input type="date" name="date_fin" required class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <hr class="my-6 border-gray-300 dark:border-gray-700">

        <div>
            <button type="button" id="toggleTaches" class="text-indigo-600 hover:underline dark:text-indigo-400">Ajouter une tâche</button>
        </div>

        <div id="tacheSection" class="hidden space-y-6">
            <div id="tacheContainer">
                <div class="tacheItem border p-4 rounded-lg dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Tâche</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text" name="taches[0][nom]" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date début</label>
                            <input type="date" name="taches[0][date_debut]" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date fin</label>
                            <input type="date" name="taches[0][date_fin]" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="taches[0][description]" rows="3" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"></textarea>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigner à</label>
                        <select name="taches[0][users][]" multiple class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} {{ $user->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="button" id="addTache" class="text-indigo-600 hover:underline dark:text-indigo-400">Ajouter une autre tâche</button>
        </div>

        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-500">Créer le projet</button>
        </div>
    </form>
</div>

@vite(['resources/js/afficheSousTache.js'])
@endsection
