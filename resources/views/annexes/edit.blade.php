@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6">Modifier l’annexe : {{ $annexe->nom }}</h2>

    <form action="{{ route('annexes.update', $annexe) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($annexe->type === 'annexe_texte')
            <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Texte</label>
            <textarea 
                name="description" 
                rows="4" 
                required 
                class="w-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >{{ $annexe->description }}</textarea>

        @elseif ($annexe->type === 'annexe_fichier')
            <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Fichier actuel :</label>
            <a href="{{ asset('storage/' . $annexe->repertoire) }}" class="text-blue-500 underline" target="_blank">📎 {{ $annexe->nom }}</a>

            <label class="block mt-4 mb-2 font-semibold text-gray-700 dark:text-gray-300">Nouveau fichier</label>
            <input 
                type="file" 
                name="fichier" 
                required 
                class="w-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        @endif

        <button 
            class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium transition"
        >
            Enregistrer
        </button>
    </form>
</div>
@endsection
