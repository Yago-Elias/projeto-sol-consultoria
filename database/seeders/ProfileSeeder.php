<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::factory()->create([
            'profile' => 'admin',
            'manage_users' => Permissions::CREATE | Permissions::EDIT | Permissions::REMOVE | Permissions::LIST,
            'manage_projects' => Permissions::CREATE | Permissions::EDIT | Permissions::REMOVE | Permissions::LIST_ALL_PROJECTS,
            'system_config' => true,
            'global_access' => true,
        ]);
        Profile::factory(10)->create();
    }
}
