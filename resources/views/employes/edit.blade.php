<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('employes.update', $employe->id) }}">
                @csrf
                @method('PATCH')
                
                <!-- Nom -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Nom')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$employe->name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Prénom -->
                <div class="mt-4">
                    <x-input-label for="prenom" :value="__('Prénom')" />
                    <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="$employe->prenom" required />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$employe->email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Date de naissance -->
                <div class="mt-4">
                    <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                    <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" :value="$employe->date_naissance" required />
                    <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                </div>

                <!-- Lieu de naissance -->
                <div class="mt-4">
                    <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                    <x-text-input id="lieu_naissance" class="block mt-1 w-full" type="text" name="lieu_naissance" :value="$employe->lieu_naissance" required />
                    <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
                </div>

                <!-- Nationalité -->
                <div class="mt-4">
                    <x-input-label for="nationalite" :value="__('Nationalité')" />
                    <x-text-input id="nationalite" class="block mt-1 w-full" type="text" name="nationalite" :value="$employe->nationalite" required />
                    <x-input-error :messages="$errors->get('nationalite')" class="mt-2" />
                </div>

                <!-- Situation matrimoniale -->
                <div class="mt-4">
                    <x-input-label for="situation_matrimoniale" :value="__('Situation matrimoniale')" />
                    <select id="situation_matrimoniale" name="situation_matrimoniale" class="block mt-1 w-full" required>
                        @foreach (['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'] as $situation)
                            <option value="{{ $situation }}" {{ $employe->situation_matrimoniale === $situation ? 'selected' : '' }}>
                                {{ $situation }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('situation_matrimoniale')" class="mt-2" />
                </div>

                <!-- Nombre d'enfants -->
                <div class="mt-4">
                    <x-input-label for="nombre_enfants" :value="__('Nombre d\'enfants')" />
                    <x-text-input id="nombre_enfants" class="block mt-1 w-full" type="number" name="nombre_enfants" :value="$employe->nombre_enfants" required />
                    <x-input-error :messages="$errors->get('nombre_enfants')" class="mt-2" />
                </div>

                <!-- Adresse -->
                <div class="mt-4">
                    <x-input-label for="adresse" :value="__('Adresse')" />
                    <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="$employe->adresse" required />
                    <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                </div>

                <!-- Téléphone -->
                <div class="mt-4">
                    <x-input-label for="telephone" :value="__('Téléphone')" />
                    <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="$employe->telephone" required />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>

                <!-- Sexe -->
                <div class="mt-4">
                    <x-input-label for="sexe" :value="__('Sexe')" />
                    <select id="sexe" name="sexe" class="block mt-1 w-full" required>
                        @foreach (['Homme', 'Femme', 'Autre'] as $sexe)
                            <option value="{{ $sexe }}" {{ $employe->sexe === $sexe ? 'selected' : '' }}>{{ $sexe }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
                </div>

                <!-- CNI -->
                <div class="mt-4">
                    <x-input-label for="cni" :value="__('CNI')" />
                    <x-text-input id="cni" class="block mt-1 w-full" type="text" name="cni" :value="$employe->cni" required />
                    <x-input-error :messages="$errors->get('cni')" class="mt-2" />
                </div>

                <!-- Salaire -->
                <div class="mt-4">
                    <x-input-label for="salaire" :value="__('Salaire')" />
                    <x-text-input id="salaire" class="block mt-1 w-full" type="number" step="0.01" name="salaire" :value="$employe->salaire" required />
                    <x-input-error :messages="$errors->get('salaire')" class="mt-2" />
                </div>

                <!-- Dates de contrat -->
                <div class="mt-4">
                    <x-input-label for="date_debut_contrat" :value="__('Date début contrat')" />
                    <x-text-input id="date_debut_contrat" class="block mt-1 w-full" type="date" name="date_debut_contrat" :value="$employe->date_debut_contrat" required />
                    <x-input-error :messages="$errors->get('date_debut_contrat')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="date_fin_contrat" :value="__('Date fin contrat')" />
                    <x-text-input id="date_fin_contrat" class="block mt-1 w-full" type="date" name="date_fin_contrat" :value="$employe->date_fin_contrat" />
                    <x-input-error :messages="$errors->get('date_fin_contrat')" class="mt-2" />
                </div>

                <!-- Poste -->
                <div class="mt-4">
                    <x-input-label for="poste_id" :value="__('Poste')" />
                    <select id="poste_id" name="poste_id" class="block mt-1 w-full" required>
                        @foreach ($postes as $poste)
                            <option value="{{ $poste->id }}" {{ $employe->poste_id == $poste->id ? 'selected' : '' }}>
                                {{ $poste->nom_poste }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('poste_id')" class="mt-2" />
                </div>

                <!-- Équipe -->
                <div class="mt-4">
                    <x-input-label for="equipe_id" :value="__('Équipe')" />
                    <select id="equipe_id" name="equipe_id" class="block mt-1 w-full" required>
                        @foreach ($equipes as $equipe)
                            <option value="{{ $equipe->id }}" {{ $employe->equipe_id == $equipe->id ? 'selected' : '' }}>
                                {{ $equipe->nom }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('equipe_id')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <x-primary-button>
                        {{ __('Enregistrer les modifications') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
