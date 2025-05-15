<x-guest-layout>
    <form method="POST" action="{{ route('employes.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Prenom -->
        <div class="mt-4">
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Date de naissance -->
        <div class="mt-4">
            <x-input-label for="date_naissance" :value="__('Date de naissance')" />
            <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" :value="old('date_naissance')" required />
            <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
        </div>

        <!-- Lieu de naissance -->
        <div class="mt-4">
            <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
            <x-text-input id="lieu_naissance" class="block mt-1 w-full" type="text" name="lieu_naissance" :value="old('lieu_naissance')" required />
            <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
        </div>

        <!-- Nationalité -->
        <div class="mt-4">
            <x-input-label for="nationalite" :value="__('Nationalité')" />
            <x-text-input id="nationalite" class="block mt-1 w-full" type="text" name="nationalite" :value="old('nationalite')" required />
            <x-input-error :messages="$errors->get('nationalite')" class="mt-2" />
        </div>

        <!-- Situation matrimoniale -->
        <div class="mt-4">
            <x-input-label for="situation_matrimoniale" :value="__('Situation matrimoniale')" />
            <select id="situation_matrimoniale" name="situation_matrimoniale" class="block mt-1 w-full" required>
                <option value="">-- Choisir --</option>
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
                <option value="Veuf(ve)">Veuf(ve)</option>
            </select>
            <x-input-error :messages="$errors->get('situation_matrimoniale')" class="mt-2" />
        </div>

        <!-- Nombre d'enfants -->
        <div class="mt-4">
            <x-input-label for="nombre_enfants" :value="__('Nombre d\'enfants')" />
            <x-text-input id="nombre_enfants" class="block mt-1 w-full" type="number" name="nombre_enfants" :value="old('nombre_enfants')" required />
            <x-input-error :messages="$errors->get('nombre_enfants')" class="mt-2" />
        </div>

        <!-- Adresse -->
        <div class="mt-4">
            <x-input-label for="adresse" :value="__('Adresse')" />
            <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse')" required />
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
        </div>

        <!-- Téléphone -->
        <div class="mt-4">
            <x-input-label for="telephone" :value="__('Téléphone')" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <!-- Sexe -->
        <div class="mt-4">
            <x-input-label for="sexe" :value="__('Sexe')" />
            <select id="sexe" name="sexe" class="block mt-1 w-full" required>
                <option value="">-- Choisir --</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>
            <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
        </div>

        <!-- CNI -->
        <div class="mt-4">
            <x-input-label for="cni" :value="__('CNI')" />
            <x-text-input id="cni" class="block mt-1 w-full" type="text" name="cni" :value="old('cni')" required />
            <x-input-error :messages="$errors->get('cni')" class="mt-2" />
        </div>

        <!-- Salaire -->
        <div class="mt-4">
            <x-input-label for="salaire" :value="__('Salaire')" />
            <x-text-input id="salaire" class="block mt-1 w-full" type="number" name="salaire" :value="old('salaire')" required step="0.01" />
            <x-input-error :messages="$errors->get('salaire')" class="mt-2" />
        </div>

        <!-- Date début contrat -->
        <div class="mt-4">
            <x-input-label for="date_debut_contrat" :value="__('Date début contrat')" />
            <x-text-input id="date_debut_contrat" class="block mt-1 w-full" type="date" name="date_debut_contrat" :value="old('date_debut_contrat')" required />
            <x-input-error :messages="$errors->get('date_debut_contrat')" class="mt-2" />
        </div>

        <!-- Date fin contrat -->
        <div class="mt-4">
            <x-input-label for="date_fin_contrat" :value="__('Date fin contrat (facultative)')" />
            <x-text-input id="date_fin_contrat" class="block mt-1 w-full" type="date" name="date_fin_contrat" :value="old('date_fin_contrat')" />
            <x-input-error :messages="$errors->get('date_fin_contrat')" class="mt-2" />
        </div>

        <!-- Poste ID -->
        <div class="mt-4">
            <x-input-label for="poste_id" :value="__('Poste')" />
            <select id="poste_id" name="poste_id" class="block mt-1 w-full" required>
                @foreach ($postes as $poste)
                    <option value="{{ $poste->id }}" {{ old('poste_id') == $poste->id ? 'selected' : '' }}>
                        {{ $poste->nom_poste }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('poste_id')" class="mt-2" />
        </div>

        <!-- Equipe ID -->
        <div class="mt-4">
            <x-input-label for="equipe_id" :value="__('Équipe')" />
            <select id="equipe_id" name="equipe_id" class="block mt-1 w-full" required>
                @foreach ($equipes as $equipe)
                    <option value="{{ $equipe->id }}" {{ old('equipe_id') == $equipe->id ? 'selected' : '' }}>
                        {{ $equipe->nom }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('equipe_id')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
