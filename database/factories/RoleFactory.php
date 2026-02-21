<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    protected static ?Collection $profiles;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$profiles = Profile::all();
        return [
            'role' => fake()->words(1, true),
            'profile_id' => static::$profiles->random()
        ];
    }
}
