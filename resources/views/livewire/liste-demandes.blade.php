<div class="p-4 bg-white dark:bg-gray-900 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <input type="text"
               wire:model.debounce.300ms="search"
               placeholder="Rechercher une demande"
               class="px-4 py-2 border rounded w-1/3 dark:bg-gray-800 dark:text-white dark:border-gray-600"
        >

        @if(auth()->user()->poste->role === 'pdg')
            <button wire:click="toggleAllDemandes"
                class="px-4 py-2 rounded text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                @if($all)
                    Afficher uniquement les chefs de département
                @else
                    Afficher toutes les demandes
                @endif
            </button>
        @endif
    </div>

    @if(session()->has('success'))
        <div class="mb-4 text-green-600 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if($demandes->isEmpty())
        <p class="text-gray-500 dark:text-gray-400">Aucune demande trouvée.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">État</th>
                        <th class="px-4 py-2">Utilisateur</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                    @foreach($demandes as $demande)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $demande->nom }}</td>
                            <td class="px-4 py-2">{{ $demande->description }}</td>
                            <td class="px-4 py-2">{{ $demande->date_debut }}</td>
                            <td class="px-4 py-2">{{ $demande->date_fin }}</td>
                            <td class="px-4 py-2 capitalize">{{ $demande->etat_demande }}</td>
                            <td class="px-4 py-2">{{ $demande->userDemande->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $demandeuser = \App\Models\DemandeUser::where('user_id', auth()->id())
                                                    ->where('demande_id', $demande->id)
                                                    ->first();
                                @endphp

                                @if(!$demandeuser)
                                    <button wire:click="validerDemande({{ $demande->id }})"
                                        class="px-3 py-1 text-sm rounded bg-green-600 hover:bg-green-700 text-white dark:bg-green-500 dark:hover:bg-green-600">
                                        Valider
                                    </button>

                                    <button wire:click="refuserDemande({{ $demande->id }})"
                                        class="px-3 py-1 text-sm rounded bg-green-600 hover:bg-green-700 text-white dark:bg-green-500 dark:hover:bg-green-600">
                                        Réfuser
                                    </button>
                                @else
                                    @if ($demandeuser->etat === 1)
                                        <p class="text-sm text-green-500 mt-2 italic">✅ Action validée</p>
                                    @elseif ($demandeuser->etat === 0)
                                        <p class="text-sm text-red-500 mt-2 italic">❌ Action refusée</p>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
