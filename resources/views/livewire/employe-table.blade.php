<div class="ml-[5%] mr-[5%]">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <input
            wire:model.live="search"
            type="text"
            placeholder="Rechercher par nom..."
            class="w-full sm:w-1/3 p-2 rounded border dark:bg-gray-800 dark:text-white dark:border-gray-600"
        >

        <select
            wire:model.live="equipe"
            class="w-full sm:w-1/3 p-2 rounded border dark:bg-gray-800 dark:text-white dark:border-gray-600"
        >
            <option value="">-- Toutes les équipes --</option>
            @foreach($equipes as $eq)
                <option value="{{ $eq->id }}">{{ $eq->nom }}</option>
            @endforeach
        </select>

        <!-- Ajouter sous le champ de recherche et filtre -->
        <button wire:click="toggleAnciens" class="mb-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            {{ $afficherAnciens ? 'Masquer les anciens employés' : 'Afficher les anciens employés' }}
        </button>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Liste des employés</h1>

    <a href="{{ route('employes.create') }}"
       class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
        + Nouvel employé
    </a>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Prénom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Poste</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Équipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Sexe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Téléphone</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($employes as $employe)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $employe->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $employe->prenom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $employe->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $employe->poste->nom_poste ?? 'Non défini' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $employe->equipe->nom ?? 'Non défini' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($employe->sexe) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $employe->telephone }}</td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('employes.edit', $employe->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">
                                    Modifier
                                </a>

                                <form action="{{ route('employes.destroy', $employe->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet employé ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
