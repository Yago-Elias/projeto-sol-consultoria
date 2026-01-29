<?php

namespace Database\Factories;

use App\Models\FinancialNature;
use App\Models\FinancialType;
use App\Models\Project;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialEntry>
 */
class FinancialEntryFactory extends Factory
{
    protected static ?Collection $projects;
    protected static ?Collection $types;
    protected static ?Collection $natures;
    protected static ?Collection $providers;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$projects ??= Project::all();
        static::$types ??= FinancialType::all();
        static::$natures ??= FinancialNature::all();
        static::$providers ??= Provider::all();

        $dueDate = $this->faker->dateTimeBetween('+1 days', '+90 days');

        return [
            'description' => $this->faker->sentence(6),
            'total_amount' => $this->faker->randomFloat(2, 100, 50000),
            'total_installments' => $this->faker->numberBetween(1, 12),
            'due_date' => $dueDate,
            'payment_date' => $this->faker->boolean(30) ? $this->faker->dateTimeBetween($dueDate, '+30 days') : null,
            'project_id' => static::$projects->random(),
            'type' => static::$types->random(),
            'nature' => static::$natures->random(),
            'provider' => static::$providers->random(),
        ];
    }
}
