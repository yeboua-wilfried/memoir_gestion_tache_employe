@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Modifier le Département</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departements.update', $departement->id) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nom du Département</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $departement->nom) }}"
                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $departement->description) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
