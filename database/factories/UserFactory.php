<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected static ?Collection $profiles;
    protected static ?Collection $roles;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$roles = Role::all();
        $faker = fake('pt_BR');

        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'image' => 'https://picsum.photos/seed/' . $faker->uuid() . '/640/480',
            'password' => static::$password ??= Hash::make('password'),
            'salary' => $faker->randomFloat(2, 1000, 10000),
            'telephone' => $faker->phoneNumber(),
            'remember_token' => Str::random(10),

            'role_id' => static::$roles->random(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
