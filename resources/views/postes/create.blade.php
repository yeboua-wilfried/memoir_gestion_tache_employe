@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Créer un nouveau poste</h2>

    <form action="{{ route('postes.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
        @csrf

        <!-- Nom du poste -->
        <div>
            <label for="nom_poste" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom du poste</label>
            <input type="text" name="nom_poste" id="nom_poste" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm" value="{{ old('nom_poste') }}" required>
            @error('nom_poste')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Rôle -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rôle</label>
            <select name="role" id="role" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm" required>
                <option value="">-- Sélectionnez un rôle --</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                <option value="super_employe" {{ old('role') === 'super_employe' ? 'selected' : '' }}>Super employé</option>
                <option value="medium_employe" {{ old('role') === 'medium_employe' ? 'selected' : '' }}>Employé medium</option>
                <option value="bottom_employe" {{ old('role') === 'bottom_employe' ? 'selected' : '' }}>Employé simple</option>
            </select>
            @error('role')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex justify-end">
            <a href="{{ route('postes.index') }}" class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-white px-4 py-2 rounded mr-2">Annuler</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
