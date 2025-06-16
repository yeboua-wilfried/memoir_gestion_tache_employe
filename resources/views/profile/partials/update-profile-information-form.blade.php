<section class="mt-8 bg-white dark:bg-gray-800 p-8 max-w-full mx-auto">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            🧾 Informations Essentielles du Profil
        </h2>
        <p class="mt-1 text-base text-gray-600 dark:text-gray-300">
            Ces informations décrivent votre identité au sein de l'organisation.
        </p>
    </header>

    <div class="grid grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-6 my-6">
            <div class="border rounded-lg my-6 p-4 bg-gray-50 dark:bg-gray-700">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nom</label>
                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->name }} {{ $user->prenom }}</p>
            </div>

            <div class="border rounded-lg my-6 p-4 bg-gray-50 dark:bg-gray-700">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->email }}</p>
            </div>

            <div class="border rounded-lg my-6 p-4 bg-gray-50 dark:bg-gray-700">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Équipe</label>
                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->equipe->nom ?? 'Non assignée' }}</p>
            </div>

            <div class="border rounded-lg my-6 p-4 bg-gray-50 dark:bg-gray-700">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Département</label>
                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->equipe->departement->nom ?? 'Non défini' }}</p>
            </div>

            <div class="border rounded-lg my-6 p-4 bg-gray-50 dark:bg-gray-700">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Date de création</label>
                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-6">
            @if($superieurs->isNotEmpty())
                <div class="col-span-1 md:col-span-2 lg:col-span-3 mt-8">
                    <div class="bg-gradient-to-br from-blue-100 via-white to-blue-50 dark:from-gray-700 dark:to-gray-800 p-6 rounded-xl shadow-md border border-blue-200 dark:border-gray-600">
                        <h3 class="text-2xl font-bold text-blue-800 dark:text-blue-200 flex items-center gap-2 mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            Supérieurs hiérarchiques
                        </h3>

                        <div class="space-y-4">
                            @foreach ($superieurs as $sup)
                                <div class="flex items-center justify-between bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md px-4 py-3 shadow-sm hover:shadow-md transition">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $sup->name ?? 'Nom inconnu' }} {{ $sup->prenom ?? '' }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ ucfirst($sup->equipe->nom ?? 'non défini') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $sup->poste->nom_poste ?? 'Poste inconnu' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-center my-2">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            @endforeach
                            <div class="flex items-center justify-between bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md px-4 py-3 shadow-sm hover:shadow-md transition">
                                <div>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $user->name ?? 'Nom inconnu' }} {{ $user->prenom ?? '' }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ ucfirst($sup->equipe->nom ?? 'non défini') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $user->poste->nom_poste ?? 'Poste inconnu' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
