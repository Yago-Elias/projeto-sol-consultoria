<?php

namespace Database\Factories;

use App\Permissions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectAttribution>
 */
class ProjectAttributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribution' => 'collaborator',
            'task_access' => Permissions::CREATE | Permissions::LIST | Permissions::EDIT,
            'board_access' => Permissions::CREATE | Permissions::LIST,
            'financial_access' => Permissions::NONE
        ];
    }
}
