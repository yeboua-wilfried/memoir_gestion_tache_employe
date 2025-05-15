@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Travail sur la tâche : {{ $tache->nom }}</h1>
    <p>{{ $tache->description }}</p>

    <hr>

    <h3>Ajouter une annexe</h3>
    <form action="{{ route('annexes.store', $tache->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nom">Nom de l'annexe</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="fichier">Ajouter un fichier (optionnel)</label>
            <input type="file" name="fichier" class="form-control">
        </div>

        <div class="mb-3">
            <label for="texte">Ou ajouter un texte (optionnel)</label>
            <textarea name="texte" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter l'annexe</button>
    </form>

    <hr>

    <h4>Annexes existantes :</h4>
    <ul>
        @foreach ($tache->annexes as $annexe)
            <li>
                <strong>{{ $annexe->nom }}</strong> - {{ $annexe->type }} - {{ $annexe->taille }} octets
            </li>
        @endforeach
    </ul>
</div>
@endsection
