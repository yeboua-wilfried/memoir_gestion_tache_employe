<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Poste;
use App\Models\Equipe;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sexe = $this->faker->randomElement(['Homme', 'Femme']);

        return [
            'name' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName($sexe == 'Homme' ? 'male' : 'female'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Mot de passe par défaut
            'date_naissance' => $this->faker->date('Y-m-d', '2000-01-01'),
            'lieu_naissance' => $this->faker->city(),
            'nationalite' => $this->faker->country(),
            'situation_matrimoniale' => $this->faker->randomElement(['Célibataire', 'Marié(e)', 'Divorcé(e)']),
            'nombre_enfants' => $this->faker->numberBetween(0, 5),
            'adresse' => $this->faker->address(),
            'telephone' => $this->faker->phoneNumber(),
            'sexe' => $sexe,
            'cni' => $this->faker->numerify('###########'),
            'salaire' => $this->faker->numberBetween(200000, 1000000),
            'date_debut_contrat' => $this->faker->date(),
            'date_fin_contrat' => $this->faker->optional()->date(),
            'poste_id' => Poste::inRandomOrder()->first()?->id ?? 1,
            'equipe_id' => Equipe::inRandomOrder()->first()?->id ?? 1,
            'disponibilite_user' => $this->faker->randomElement(['Disponible', 'Indisponible']),
            'presence_absence' => $this->faker->randomElement(['Présent', 'Absent']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    /*public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }*/
}
