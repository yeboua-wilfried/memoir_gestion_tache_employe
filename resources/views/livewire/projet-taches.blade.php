<div class="p-6 dark:text-white rounded-lg shadow">
    <!-- Boutons de création -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex gap-4">
            <a href="{{ route('projets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nouveau Projet
            </a>
            <a href="{{ route('tache.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Nouvelle Tâche
            </a>
        </div>
        <input wire:model.debounce.300ms="search" type="text" placeholder="Rechercher une tâche ou un projet..."
            class="w-1/3 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <!-- Projets -->
    <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-300 mb-4">Projets</h2>
    @forelse($projets as $projet)
        <div class="border border-blue-300 dark:border-blue-500 rounded-lg p-4 mb-6 bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold">{{ $projet->nom }}</h3>
                <div class="flex gap-2">
                    <a href="{{ route('projets.edit', $projet->id) }}" class="text-sm text-yellow-500 hover:underline">Modifier</a>
                    <button onclick="toggleModal('modal-{{ $projet->id }}')" class="text-sm text-red-500 hover:underline">Supprimer</button>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $projet->description }}</p>
            <button onclick="document.getElementById('taches-{{ $projet->id }}').classList.toggle('hidden')"
                class="text-sm text-blue-500 dark:text-blue-300 hover:underline mb-2">Afficher/Masquer les tâches</button>

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

        <!-- Modal de suppression -->
        <div id="modal-{{ $projet->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg max-w-md w-full">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Suppression du projet</h2>
                <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">Souhaitez-vous supprimer aussi les tâches liées à ce projet ou les conserver ?</p>
                <div class="flex justify-end gap-4">
                    <form method="POST" action="{{ route('projets.destroy', $projet->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="option" value="delete_tasks">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Supprimer tout</button>
                    </form>
                    <form method="POST" action="{{ route('projets.destroy', $projet->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="option" value="detach_tasks">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Détacher les tâches</button>
                    </form>
                    <button onclick="toggleModal('modal-{{ $projet->id }}')" class="text-gray-700 dark:text-gray-300">Annuler</button>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-600 dark:text-gray-400">Aucun projet trouvé.</p>
    @endforelse

    <!-- Tâches Simples -->
    <h2 class="text-2xl font-bold text-green-700 dark:text-green-400 mt-10 mb-4">Tâches Simples</h2>

        <div class="overflow-x-auto mb-4 border border-green-300 dark:border-green-500 rounded bg-white dark:bg-gray-800">
            <table class="w-full table-auto text-sm">
                <thead class="bg-green-100 dark:bg-green-900">
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">État</th>
                        <th class="px-4 py-2">Assignée à</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tachesSimples as $tache)
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
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('taches.edit', $tache->id) }}" class="text-yellow-500 hover:underline">Modifier</a>

                                    <form action="{{ route('taches.destroy', $tache->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">Aucune tâche simple trouvée.</p>
                    @endforelse
                </tbody>
            </table>
        </div>

</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.toggle('hidden');
    }
</script>
