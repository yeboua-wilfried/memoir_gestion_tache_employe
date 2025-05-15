<div class="p-6 dark:text-white rounded-lg shadow">
    <!-- Boutons de création -->
    <div class="flex justify-end space-x-4 mb-4">
        <a href="{{ route('projets.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Nouveau Projet
        </a>
        <a href="{{ route('taches.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            + Nouvelle Tâche
        </a>
    </div>

    <!-- Barre de recherche -->
    <div class="mb-4">
        <input wire:model.debounce.300ms="search"
               type="text"
               placeholder="Rechercher une tâche ou un projet..."
               class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <!-- Projets -->
    <h2 class="text-xl font-bold text-blue-700 dark:text-blue-300 mb-3">Projets</h2>
    @forelse($projets as $projet)
        <div class="border border-blue-300 dark:border-blue-500 rounded p-4 mb-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold">{{ $projet->nom }}</h3>
                <button onclick="document.getElementById('taches-{{ $projet->id }}').classList.toggle('hidden')"
                        class="text-sm text-blue-500 dark:text-blue-300 hover:underline">
                    Afficher/Masquer les tâches
                </button>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $projet->description }}</p>

            <div id="taches-{{ $projet->id }}" class="hidden">
                @if($projet->taches->count())
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse text-sm">
                            <thead>
                                <tr class="bg-blue-100 dark:bg-blue-900 text-left">
                                    <th class="px-4 py-2">Nom</th>
                                    <th class="px-4 py-2">Description</th>
                                    <th class="px-4 py-2">Début</th>
                                    <th class="px-4 py-2">Fin</th>
                                    <th class="px-4 py-2">État</th>
                                    <th class="px-4 py-2">Assignée à</th>
                                    <th class="px-4 py-2">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projet->taches as $tache)
                                    <tr class="border-b dark:border-gray-600">
                                        <td class="px-4 py-2">{{ $tache->nom }}</td>
                                        <td class="px-4 py-2">{{ $tache->description }}</td>
                                        <td class="px-4 py-2">{{ $tache->date_debut }}</td>
                                        <td class="px-4 py-2">{{ $tache->date_fin }}</td>
                                        <td class="px-4 py-2">{{ $tache->etat }}</td>
                                        <td class="px-4 py-2">
                                            @if($tache->tacheRealiserUsers->isNotEmpty())
                                                {{ $tache->tacheRealiserUsers->pluck('name')->join(', ') }}
                                            @else
                                                Non assigné
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ $tache->typeTache->nom ?? 'Non défini' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm italic text-gray-500 dark:text-gray-400">Aucune tâche pour ce projet.</p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-600 dark:text-gray-400">Aucun projet trouvé.</p>
    @endforelse

    <!-- Tâches Simples -->
    <h2 class="text-xl font-bold text-green-700 dark:text-green-400 mt-8 mb-3">Tâches Simples</h2>
    @forelse($tachesSimples as $tache)
        <div class="overflow-x-auto mb-4 border border-green-300 dark:border-green-500 rounded">
            <table class="w-full table-auto text-sm">
                <thead class="bg-green-100 dark:bg-green-900">
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">État</th>
                        <th class="px-4 py-2">Assignée à</th>
                        <th class="px-4 py-2">Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b dark:border-gray-600">
                        <td class="px-4 py-2">{{ $tache->nom }}</td>
                        <td class="px-4 py-2">{{ $tache->description }}</td>
                        <td class="px-4 py-2">{{ $tache->date_debut }}</td>
                        <td class="px-4 py-2">{{ $tache->date_fin }}</td>
                        <td class="px-4 py-2">{{ $tache->etat }}</td>
                        <td class="px-4 py-2">{{ $tache->user->name ?? 'Non assigné' }}</td>
                        <td class="px-4 py-2">{{ $tache->typeTache->nom ?? 'Non défini' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @empty
        <p class="text-gray-600 dark:text-gray-400">Aucune tâche simple trouvée.</p>
    @endforelse
</div>
