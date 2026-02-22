<?php

namespace Database\Factories;

use App\Permissions;
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
            'manage_projects' => Permissions::LIST | Permissions::CREATE | Permissions::MANAGE_PROJECTS,
            'task_access' => Permissions::LIST | Permissions::CREATE | Permissions::EDIT | Permissions::FINANCIAL_ACCESS,
            'financial_access' => Permissions::CREATE | Permissions::EDIT | Permissions::LIST,
            'manage_users' => Permissions::NONE,
            'system_config' => false,
            'global_access' => false,
        ];
    }
}
