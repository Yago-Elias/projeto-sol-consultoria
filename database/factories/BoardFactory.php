<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    protected static ?Collection $projects;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$projects ??= Project::all();
        return [
            'name' => fake()->word(),
            'project_id' => static::$projects->random(),
        ];
    }
}
