@extends('layouts.app')

@section('content')
<div class="w-full mx-[10px] px-4 py-8">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Créer une tâche</h2>

    <form action="{{ route('taches.store') }}" method="POST" class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
            <input type="text" name="taches[0][nom]" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
            <div class="max-h-40 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md p-2 space-y-1 bg-white dark:bg-gray-800">
                @foreach($users as $user)
                    @php
                        $tachesCount = $user->tache_realiser_users_count;
                        $color = 'text-green-600';
                        if ($tachesCount >= 3) {
                            $color = 'text-red-600';
                        } elseif ($tachesCount == 2) {
                            $color = 'text-orange-500';
                        }
                    @endphp

                    <label class="flex items-center justify-between px-3 mb-2 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="taches[0][users][]" value="{{ $user->id }}"
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
