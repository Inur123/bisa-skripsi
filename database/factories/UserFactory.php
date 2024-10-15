<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Default password: 'password'
            'role' => 'mahasiswa', // Default role
            'nim' => $this->faker->unique()->numberBetween(1000, 9999),
            'fakultas' => $this->faker->randomElement(['Teknik', 'Ekonomi', 'PAI']),
            'prodi' => $this->faker->randomElement(['Informatika', 'Manajemen', 'Agama Islam']),
            'file' => '', // No file by default
            'kelompok' => null, // Not assigned to a group yet
        ];
    }
}
