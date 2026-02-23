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
        User::factory()
            ->for(Role::find(1))
            ->create([
                'name' => 'dev',
                'email' => 'dev@dev.net',
                'password' => bcrypt('dev'),
            ]);

        $users = [
            ['name' => 'Yago Elias',        'email' => 'yago_elias@email.com',        'salary' => '8100'],
            ['name' => 'Vitor Rodrigues',   'email' => 'vitor_rodrigues@email.com',   'salary' => '8200'],
            ['name' => 'Rener Pontes',      'email' => 'rener_pontes@email.com',      'salary' => '8300'],
            ['name' => 'Gabriel Santos',    'email' => 'gabriel_santos@email.com',    'salary' => '8400'],
            ['name' => 'Thales Damasceno',  'email' => 'thales_damasceno@email.com',  'salary' => '8500'],
            ['name' => 'Yuri Venceslau',    'email' => 'yuri_venceslau@email.com',    'salary' => '8600'],
            ['name' => 'Rodrigo Joaquim',   'email' => 'rodrigo_joaquim@email.com',   'salary' => '8700'],
            ['name' => 'Victor Laércio',    'email' => 'victor_laercio@email.com',    'salary' => '8800'],
            ['name' => 'Benedito Elton',    'email' => 'benedito_elton@email.com',    'salary' => '8900'],
        ];

        $roles = Role::all();

        foreach ($users as $user) {
            User::factory()
                ->for($roles->random())
                ->create($user);
        }
    }
}
