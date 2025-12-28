<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employee $employee, Role $role): bool
    {
        return $employee->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('roles.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $employee, Role $role): bool
    {
        return $employee->hasAbility('roles.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $employee, Role $role): bool
    {
        return $employee->hasAbility('roles.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $employee, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employee $employee, Role $role): bool
    {
        return false;
    }
}
