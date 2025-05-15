@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold mb-6 dark:text-white dark:border-gray-600">Liste des Tâches & Projets</h1>

        @livewire('projet-taches')
    </div>
@endsection
