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
        $faker = fake('pt_BR');

        $price = $faker->randomFloat(2, 1000);
        $start_date = $faker->dateTime();
        return [
            'name' => $faker->words(3, true),
            'description' => $faker->paragraph(),
            'image' => 'https://picsum.photos/seed/' . $faker->uuid() . '/640/480',
            'company_name' => $faker->company(),
            'company_email' => $faker->companyEmail(),
            'project_price' => $price,
            'estimated_cost' => $faker->randomFloat(2, max: $price),
            'start_date' => $start_date,
            'end_date' => $faker->dateTimeBetween($start_date, '+ 5 years'),
            'manager_id' => static::$users->random()
        ];
    }
}
