<?php

namespace App\Policies;

use App\Models\User;
use App\Permissions;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user['profile']['global_access'])
            return true;

        return $user['profile']['manage_users'] & Permissions::LIST;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user['profile']['global_access'])
            return true;

        if ($user['profile']['manage_users'] & Permissions::LIST)
            return true;

        return $user['id'] === $model['id'];
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user['profile']['global_access'])
            return true;

        return $user['profile']['manage_users'] & Permissions::CREATE;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user['profile']['global_access'])
            return true;

        return $user['profile']['manage_users'] & Permissions::EDIT;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user['profile']['global_access'])
            return true;

        return $user['profile']['manage_users'] & Permissions::REMOVE &&
            $model['managedProjects']->merge($model['projects'])->count() === 0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
