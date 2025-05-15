@extends('layouts.app')

@section('content')
<div class="w-full p-6">

    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Nouvelle Demande d'Indisponibilité</h2>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <form action="{{ route('demandes.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="description" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Description (optionnelle)</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="mb-4">
                <label for="motif_abs" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Motif d'absence</label>
                <select id="motif_abs" name="motif_abs" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Sélectionner un motif --</option>
                    <option value="1">Congé annuel</option>
                    <option value="2">Congé maladie</option>
                    <option value="3">Congé maternité</option>
                    <option value="4">Congé paternité</option>
                    <option value="5">Congé sans solde</option>
                    <option value="6">Congé de formation</option>
                    <option value="9">Congé pour raisons de santé</option>
                    <option value="10">Autre</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="date_debut" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="date_fin" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Date de fin</label>
                    <input type="date" id="date_fin" name="date_fin" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                    Envoyer la demande
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
