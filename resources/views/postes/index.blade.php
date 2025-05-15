@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Liste des Postes</h2>
        <a href="{{ route('postes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Nouveau Poste
        </a>
    </div>

    @if($postes->isEmpty())
        <p class="text-gray-600 dark:text-gray-300">Aucun poste enregistré pour le moment.</p>
    @else
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Nom du Poste</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">rôle</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach($postes as $poste)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $poste->nom_poste }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $poste->description }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $poste->role }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('postes.edit', $poste->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">Modifier</a>
                                <form action="{{ route('postes.destroy', $poste->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce poste ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
