@extends('layouts.app')

@section('content')
<div class="w-full p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Mes Demandes d'Indisponibilité</h2>

        <a href="{{ route('demandes.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
            Nouvelle Demande
        </a>
    </div>

    @if($demandes->isEmpty())
        <p class="text-gray-600 dark:text-gray-300">Vous n'avez encore fait aucune demande.</p>
    @else
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 dark:bg-gray-700">
                    <tr class="text-left text-gray-800 dark:text-gray-100">
                        <th class="py-3 px-6">Date</th>
                        <th class="py-3 px-6">Motif</th>
                        <th class="py-3 px-6">Période</th>
                        <th class="py-3 px-6">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                    @foreach($demandes as $demande)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400">
                            <td class="py-3 px-6">{{ $demande->created_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-6">{{ $demande->motif_absence ?? 'Non spécifié' }}</td>
                            <td class="py-3 px-6">{{ $demande->date_debut }} au {{ $demande->date_fin }}</td>
                            <td class="py-3 px-6">
                                @if($demande->etat_demande == 'validée')
                                    <span class="px-3 py-1 inline-flex text-sm rounded-full bg-green-200 text-green-800 font-semibold">Acceptée</span>
                                @elseif($demande->etat_demande == 'refusée')
                                    <span class="px-3 py-1 inline-flex text-sm rounded-full bg-red-200 text-red-800 font-semibold">Refusée</span>
                                @elseif($demande->etat_demande == 'expirée')
                                    <span class="px-3 py-1 inline-flex text-sm rounded-full bg-red-700 text-gray-800 font-semibold">Expirée</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm rounded-full bg-yellow-200 text-yellow-800 font-semibold">En attente</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
