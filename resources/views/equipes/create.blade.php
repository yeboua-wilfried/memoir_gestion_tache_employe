@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Créer une Équipe</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipes.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="departement_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Département</label>
            <select name="departement_id" id="departement_id"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm">
                <option value="">-- Sélectionner --</option>
                @foreach ($departements as $dep)
                    <option value="{{ $dep->id }}" {{ old('departement_id') == $dep->id ? 'selected' : '' }}>
                        {{ $dep->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
