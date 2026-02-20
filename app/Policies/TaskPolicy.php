<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Permissions;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Project $project = null): bool
    {
        if ($user['profile']['global_access'])
            return true;

        if ($project && $user['id'] === $project['manager_id'])
            return true;

        return $user['profile']['task_access'] & Permissions::CREATE;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
//        dd($task['project']);
        if ($user['profile']['global_access'] || $user['id'] === $task['project']['manager_id'])
            return true;

        return $user['profile']['task_access'] & Permissions::EDIT;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if ($user['profile']['global_access']|| $user['id'] === $task['project']['manager_id'])
            return true;

        return $user['profile']['task_access'] & Permissions::REMOVE;
    }

    public function approve(User $user, Task $task): bool
    {
        if ($user['profile']['global_access'] || $user['id'] === $task['project']['manager_id'])
            return $task['status'] === 'EM_APROVACAO';

        if ($task['assignedTo']['id'] === $user['id'])
            return false;

        return ($user['profile']['task_access'] & Permissions::APPROVE_TASKS) &&
               $task['status'] === 'EM_APROVACAO';
    }

    public function start(User $user, Task $task): bool
    {
        return $task['status'] === 'PENDENTE' && $task['assignedTo']['id'] === $user['id'];
    }

    public function conclude(User $user, Task $task): bool
    {
        return $task['status'] === 'EM_PROGRESSO' && $task['assignedTo']['id'] === $user['id'];
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
