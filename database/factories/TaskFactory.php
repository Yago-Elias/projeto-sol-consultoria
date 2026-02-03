<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected static ?Collection $boards = null;
    protected static ?Collection $users = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$boards ??= Board::all();
        static::$users ??= User::all();

        $newRecord = [
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'predicted_hours' => fake()->numberBetween(3, 10),
            'due_date' => fake()->dateTimeThisMonth(),
            'conclusion_date' => fake()->optional()->dateTimeThisMonth(),
            'conclusion_message' => null,
            'status' => 'PENDENTE',
            'board_id' => static::$boards->random(),
            'assigned_to' => static::$users->random(),
        ];

        if ($newRecord['conclusion_date'] != null) {
            $newRecord['status'] = fake()->randomElement(['EM_APROVACAO', 'APROVADA']);
            $newRecord['conclusion_message'] = fake()->optional()->sentence();
        }

        return $newRecord;
    }
}
