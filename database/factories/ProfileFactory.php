<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // WARN: Talvez seja necessário alterar a permissão
        // quando for implementado a bitmask
        return [
            'profile' => fake()->word(),
            'permissions' => fake()->randomNumber(3)
        ];
    }
}
