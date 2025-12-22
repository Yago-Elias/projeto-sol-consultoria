<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    protected static Collection $users;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static::$users ??= User::all();

        Project::factory(3)
            ->for(User::find(1), 'manager')
            ->hasAttached(static::$users->random(5), [], 'collaborators')
            ->create();

        Project::factory(10)
            ->hasAttached(static::$users->random(5), [], 'collaborators')
            ->create();
    }
}
