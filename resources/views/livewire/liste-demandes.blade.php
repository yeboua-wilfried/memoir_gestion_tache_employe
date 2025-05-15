<div class="p-6 text-gray-900 dark:text-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Liste des demandes</h2>

    <div class="mb-4">
        <input type="text" wire:model.debounce.300ms="search"
               placeholder="Rechercher par nom de l'utilisateur..."
               class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 dark:border-gray-600 text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Demandeur</th>
                    <th class="px-4 py-2 text-left">Motif</th>
                    <th class="px-4 py-2 text-left">Date de demande</th>
                    <th class="px-4 py-2 text-left">Début</th>
                    <th class="px-4 py-2 text-left">Fin</th>
                    <th class="px-4 py-2 text-left">Validé par</th>
                    <th class="px-4 py-2 text-left">État</th>
                    <th class="px-4 py-2 text-left">Réponse</th>
                </tr>
            </thead>
            <tbody>
                @forelse($demandes as $demande)
                    @php
                        $validation = $demande->userValide->first(); // Si une seule validation attendue
                        $pivot = $validation ? $validation->pivot : null;
                    @endphp
                    <tr class="border-b dark:border-gray-600">
                        <td class="px-4 py-2">{{ $demande->userDemande->name ?? 'Inconnu' }}</td>
                        <td class="px-4 py-2">{{ $demande->motif_absence }}</td>
                        <td class="px-4 py-2">{{ $demande->date_demande }}</td>
                        <td class="px-4 py-2">{{ $demande->date_debut }}</td>
                        <td class="px-4 py-2">{{ $demande->date_fin }}</td>
                        <td class="px-4 py-2">{{ $validation->name ?? 'Non validée' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($pivot->etat_demande ?? 'en attente') }}</td>
                        <td class="px-4 py-2">{{ $pivot->date_reponce_demande ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            Aucune demande trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
