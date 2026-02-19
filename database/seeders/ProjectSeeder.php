<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Permissions;
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
        self::$users ??= User::all();

        Project::factory(3)
            ->for(User::find(1), 'manager')
            ->hasAttached(static::$users->random(5), [], 'collaborators')
            ->has(
                Board::factory(3)
                    ->has(Task::factory(5), 'tasks'),
                'boards'
            )
            ->create()
            ->each(function (Project $project) {
                $collaboratorIds = $project->collaborators->pluck('id');

                $project->boards->each(function (Board $board) use ($collaboratorIds) {
                    $board->tasks->each(function (Task $task) use ($collaboratorIds) {
                        $task->update(['assigned_to' => $collaboratorIds->random()]);
                    });
                });
            });

        Project::factory(10)
            ->hasAttached(static::$users->random(5), [], 'collaborators')
            ->has(
                Board::factory(3)
                    ->has(Task::factory(5), 'tasks'),
                'boards'
            )
            ->create()
            ->each(function (Project $project) {
                $collaboratorIds = $project->collaborators->pluck('id');

                $managerId = $collaboratorIds->random();
                $project->update(['manager_id' => $managerId]);

                $project->boards->each(function (Board $board) use ($collaboratorIds) {
                    $board->tasks->each(function (Task $task) use ($collaboratorIds) {
                        $task->update(['assigned_to' => $collaboratorIds->random()]);
                    });
                });
            });
    }
}
