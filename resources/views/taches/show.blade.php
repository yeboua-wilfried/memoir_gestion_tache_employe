@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Tâche : {{ $tache->nom }}</h2>
        @if($tache->etat !== 'terminer')
            <form action="{{ route('taches.valider', $tache) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md transition">
                    Valider la tâche
                </button>
            </form>
        @else
            <span class="text-green-600 bg-green-100 dark:bg-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm">
                Tâche terminée
            </span>
        @endif
    </div>

    <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $tache->description }}</p>

    <hr class="border-t border-gray-300 dark:border-gray-600 mb-6">

    {{-- Ajouter un texte --}}
    <h4 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-2">Ajouter une annexe texte</h4>
    <form action="{{ route('annexes.storeTexte', $tache) }}" method="POST" class="mb-6">
        @csrf
        <textarea name="description" rows="3" class="w-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Écrire ici..." required></textarea>
        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium">
            Ajouter
        </button>
    </form>

    {{-- Ajouter un fichier --}}
    <h4 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-2">Ajouter une annexe fichier</h4>
    <form action="{{ route('annexes.storeFichier', $tache) }}" method="POST" enctype="multipart/form-data" class="mb-6">
        @csrf
        <input type="file" name="fichier" class="block w-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700 rounded-md p-2" required>
        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium">
            Ajouter
        </button>
    </form>

    <hr class="border-t border-gray-300 dark:border-gray-600 mb-6">

    {{-- Liste des annexes --}}
    <h4 class="text-lg font-semibold text-teal-600 dark:text-teal-300 mb-4">Annexes</h4>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
        @forelse ($tache->annexes as $annexe)
            <div class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white p-4 rounded-md shadow flex flex-col justify-between">
                <div>
                    <h5 class="text-xl font-bold mb-1">{{ $annexe->nom }}</h5>
                    <div class="text-sm mb-2">
                        <span class="mr-4"><strong>Type :</strong> {{ $annexe->type }}</span><br>
                        <span class="mr-4"><strong>Taille :</strong> {{ $annexe->taille }} octets</span>
                    </div>

                    @if ($annexe->type == 'annexe_texte')
                        <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Contenu :</strong> {{ $annexe->description }}</p>
                    @elseif ($annexe->type == 'annexe_fichier')
                        <a href="{{ asset('storage/' . $annexe->repertoire) }}" class="inline-block mt-2 text-blue-500 hover:underline text-sm" target="_blank">📄 Télécharger</a>
                    @endif
                </div>

                <form action="{{ route('annexes.destroy', $annexe) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm w-full">
                        Supprimer
                    </button>
                </form>

                <a href="{{ route('annexes.edit', $annexe) }}" class="mt-2 block text-sm text-yellow-600 hover:underline">
                ✏️ Modifier
                </a>
            </div>
        @empty
            <p class="text-gray-500 col-span-full">Aucune annexe pour cette tâche.</p>
        @endforelse
    </div>

</div>
@endsection
