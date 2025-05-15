@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Liste des Départements</h2>
        <a href="{{ route('departements.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
            + Ajouter un département
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($departementsAvecChef as $departement)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 w-full">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $departement['nom'] }}
                </h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    {{ $departement['description'] }}
                </p>

                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <strong>Chef du Département :</strong>
                    @if ($departement['chef'])
                        {{ $departement['chef']->prenom }} {{ $departement['chef']->name }}
                    @else
                        <span class="italic text-red-500">Aucun chef assigné</span>
                    @endif
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('departements.edit', $departement['id']) }}"
                       class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded shadow">
                        Modifier
                    </a>

                    <form action="{{ route('departements.destroy', $departement['id']) }}" method="POST"
                          onsubmit="return confirm('Es-tu sûr de vouloir supprimer ce département ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded shadow">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
