<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Project;
use App\Models\ProjectAttribution;
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
        static::$users ??= User::all();
        $managerAttribution = ProjectAttribution::factory()->create([
            'attribution' => 'manager',
            'task_access' => Permissions::CREATE | Permissions::LIST | Permissions::EDIT | Permissions::REMOVE,
            'board_access' => Permissions::CREATE | Permissions::LIST | Permissions::EDIT | Permissions::REMOVE,
            'financial_access' => Permissions::FINANCIAL_ACCESS
        ]);
        $consultantAttribution = ProjectAttribution::factory()->create();


        Project::factory(3)
            ->for(User::find(1), 'manager')
            ->hasAttached(static::$users->random(5), [], 'collaborators')
            ->has(Task::factory(5), 'tasks')
            ->create()
            ->each(function (Project $project) use ($managerAttribution, $consultantAttribution) {
                $project->collaborators()->updateExistingPivot($project->manager_id, [
                    'attribution_id' => $managerAttribution->id
                ]);

                $collaboratorIds = $project->collaborators
                                           ->where('user_id', '!=', $project->manager_id)
                                           ->pluck('id');

                foreach ($collaboratorIds as $userId) {
                    $project->collaborators()->updateExistingPivot($userId, [
                        'attribution_id' => $consultantAttribution->id
                    ]);
                }

                $allCollaboratorIds = $project->collaborators->pluck('id');

                $project->tasks->each(function (Task $task) use ($allCollaboratorIds) {
                    $task->update(['assigned_to' => $allCollaboratorIds->random()]);
                });
            });

        Project::factory(10)
            ->hasAttached(static::$users->random(5), [], 'collaborators')
            ->has(Task::factory(5), 'tasks')
            ->create()
            ->each(function (Project $project) use ($consultantAttribution, $managerAttribution) {
                $collaboratorIds = $project->collaborators->pluck('id');

                // Pick a random collaborator as manager
                $managerId = $collaboratorIds->random();

                // Update project manager
                $project->update(['manager_id' => $managerId]);

                // Assign manager attribution
                $project->collaborators()->updateExistingPivot($managerId, [
                    'attribution_id' => $managerAttribution->id
                ]);

                // Assign consultant attribution to others
                foreach ($collaboratorIds->except($managerId) as $userId) {
                    $project->collaborators()->updateExistingPivot($userId, [
                        'attribution_id' => $consultantAttribution->id
                    ]);
                }

                    $project->tasks->each(function (Task $task) use ($collaboratorIds) {
                        $task->update(['assigned_to' => $collaboratorIds->random()]);
                    });
            });
    }
}
