<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Permissions;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
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
    public function view(User $user, Project $project): bool
    {
        if ($user['profile']['global_access']) {
            return true;
        }

        if ($user['profile']['manage_projects'] & Permissions::LIST_ALL_PROJECTS) {
            return true;
        }

        return $project['manager_id'] === $user['id'] ||
               $project['collaborators']->where('id', $user['id'])->count();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user['profile']['global_access']) {
            return true;
        }

        return $user['profile']['manage_projects'] & Permissions::CREATE;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        if ($user['profile']['global_access'] || $user['id'] === $project['manager_id']) {
            return true;
        }

        return $user['profile']['manage_projects'] & Permissions::EDIT;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        if ($user['profile']['global_access'] || $user['id'] === $project['manager_id']) {
            return true;
        }

        return $user['profile']['manage_projects'] & Permissions::REMOVE;
    }

    public function finance(User $user, Project $project): bool
    {
        if ($user['profile']['global_access'] || $user['id'] === $project['manager_id'])
            return true;

        return $user['profile']['manage_projects'] & Permissions::FINANCIAL_ACCESS;
    }

    public function manageProjects(User $user): bool
    {
        return $user['profile']['manage_projects'] & Permissions::MANAGE_PROJECTS;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }
}
