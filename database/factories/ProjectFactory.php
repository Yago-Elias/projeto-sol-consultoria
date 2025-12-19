<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected static Collection $users;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$users ??= User::all();

        $price = fake()->randomFloat(2, 1000);
        $start_date = fake()->dateTime();
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'image' => 'https://picsum.photos/seed/' . fake()->uuid() . '/640/480',
            'company_name' => fake()->company(),
            'company_email' => fake()->companyEmail(),
            'project_price' => $price,
            'estimated_cost' => fake()->randomFloat(2, max: $price),
            'start_date' => $start_date,
            'end_date' => fake()->dateTimeBetween($start_date, '+ 5 years'),
            'manager_id' => static::$users->random()
        ];
    }

}
