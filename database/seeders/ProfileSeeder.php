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
            'manage_projects' => Permissions::CREATE | Permissions::EDIT | Permissions::REMOVE | Permissions::LIST | Permissions::FINANCIAL_ACCESS | Permissions::MANAGE_PROJECTS,
            'task_access' => Permissions::CREATE | Permissions::EDIT | Permissions::REMOVE | Permissions::APPROVE_TASKS,
            'system_config' => true,
            'global_access' => true,
        ]);
        Profile::factory()->create([
            'profile' => 'consultant',
            'manage_users' => Permissions::NONE,
            'manage_projects' => Permissions::CREATE | Permissions::EDIT,
            'task_access' => Permissions::CREATE | Permissions::EDIT | Permissions::REMOVE | Permissions::APPROVE_TASKS,
            'system_config' => false,
            'global_access' => false,
        ]);
        Profile::factory()->create([
            'profile' => 'intern',
            'manage_users' => Permissions::NONE,
            'manage_projects' => Permissions::NONE,
            'task_access' => Permissions::NONE,
            'system_config' => false,
            'global_access' => false,
        ]);
    }
}
