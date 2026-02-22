<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = Profile::all();
        Role::factory()
            ->for(Profile::find(1))
            ->create([
                'role' => 'Proprietário'
            ]);
        Role::factory()
            ->for(Profile::find(2))
            ->create([
                'role' => 'Consultor'
            ]);
        Role::factory()
            ->for(Profile::find(3))
            ->create([
                'role' => 'Estagiário'
            ]);
    }
}
