<div class="p-6 space-y-6 bg-gray-100 dark:bg-gray-900 rounded-lg shadow">
    <div class="flex items-center space-x-2">
        <label for="departement" class="font-medium text-gray-700 dark:text-gray-200">Filtrer :</label>
        <select wire:model.live="departementId"
                id="departement"
                class="border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded px-2 py-1">
            <option value="">Tous les départements</option>
            @foreach ($departements as $dep)
                <option value="{{ $dep->id }}">{{ $dep->nom }}</option>
            @endforeach
        </select>

        <a href="{{ route('equipes.create') }}"
           class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
            + Nouvelle Équipe
        </a>
    </div>


    <table class="w-full table-auto bg-white dark:bg-gray-800 shadow rounded overflow-hidden">
        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Description</th>
                <th class="px-4 py-3 text-left">Département</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody x-data="{ showUsers: {} }">
            @foreach ($equipes as $equipe)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100 font-semibold">{{ $equipe->nom }}</td>
                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $equipe->description }}</td>
                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $equipe->departement->nom ?? 'N/A' }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <button @click="showUsers[{{ $equipe->id }}] = !showUsers[{{ $equipe->id }}]"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded shadow flex items-center space-x-2">

                            <!-- Flèche dynamique -->
                            <svg x-show="!showUsers[{{ $equipe->id }}]" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="showUsers[{{ $equipe->id }}]" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>

                        <a href="{{ route('equipes.edit', $equipe->id) }}"class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded shadow">
                            Modifier
                        </a>

                        <button wire:click="confirmDelete({{ $equipe->id }})"
                            class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded shadow">
                            Supprimer
                        </button>
                    </td>
                </tr>

                <tr class="bg-gray-50 dark:bg-gray-800" x-show="showUsers[{{ $equipe->id }}]" x-cloak>
                    <td colspan="4" class="px-6 py-4">
                        <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-gray-100">Utilisateurs de l’équipe</h3>
                        <ul class="space-y-2">
                            @forelse ($equipe->users as $user)
                                <li class="p-3 rounded bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="flex flex-col md:flex-row md:items-center space-x-2">
                                        @if ($user->poste_id == 5)
                                            <span class="text-yellow-500 font-bold">⭐ Chef : {{ $user->name }} {{ $user->prenom }}</span>
                                        @else
                                            <span class="text-gray-800 dark:text-gray-100">- {{ $user->name }} {{ $user->prenom }}</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col md:flex-row md:items-center space-x-4 mt-2 md:mt-0 text-sm text-gray-600 dark:text-gray-300">
                                        <span>
                                            <strong>Disponibilité :</strong>
                                            <span class="px-2 py-1 rounded bg-orange-500 text-white">{{ $user->disponibilite_user }}</span>
                                        </span>
                                        <span>
                                            <strong>Présence :</strong>
                                            <span class="px-2 py-1 rounded bg-green-600 text-white">{{ $user->presence_absence }}</span>
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="text-gray-500 dark:text-gray-400">Aucun utilisateur dans cette équipe.</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
