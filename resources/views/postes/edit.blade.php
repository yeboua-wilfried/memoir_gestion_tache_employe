<x-app-layout>
    <div class="py-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier un poste') }}
        </h2>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('postes.update', $poste->id) }}">
                @csrf
                @method('PUT')

                <!-- Nom du poste -->
                <div class="mb-4">
                    <x-input-label for="nom_poste" :value="__('Nom du poste')" />
                    <x-text-input id="nom_poste" name="nom_poste" type="text"
                        class="mt-1 block w-full"
                        :value="old('nom_poste', $poste->nom_poste)" required autofocus />
                    <x-input-error :messages="$errors->get('nom_poste')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring focus:ring-indigo-300"
                        rows="4">{{ old('description', $poste->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Rôle -->
                <div class="mb-4">
                    <x-input-label for="role" :value="__('Rôle associé')" />
                    <select id="role" name="role"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring focus:ring-indigo-300"
                        required>
                        @foreach(['admin' => 'Administrateur', 'super_employe' => 'Super Employé', 'medium_employe' => 'Employé Moyen', 'bottom_employe' => 'Employé Débutant'] as $key => $label)
                            <option value="{{ $key }}" {{ $poste->role === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Mettre à jour le poste') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
