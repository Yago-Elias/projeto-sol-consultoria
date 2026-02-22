<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();

        User::factory()
            ->for(Role::find(1))
            ->create([
                'name' => 'dev',
                'email' => 'dev@dev.net',
                'password' => bcrypt('dev'),
            ]);

        User::factory(10)->create();
    }
}
