<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    // public function before(Employee $employee, $ability)
    // {
    //     if ($employee->super_admin) {
    //         return true;
    //     }
    // }
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('departments.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employee $employee, Department $department): bool
    {;
        return $employee->hasAbility('departments.view')||
               ($employee->hasAbility('departments.view_own'));
    }

    public function viewOwn(Employee $employee): bool
    {
        return $employee->hasAbility('departments.view_own');
    }
    /**
     * Determine whether the user can create models.
     */
    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('departments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $employee, Department $department): bool
    {
        return $employee->hasAbility('departments.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $employee, Department $department): bool
    {
        return $employee->hasAbility('departments.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $employee, Department $department): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employee $employee, Department $department): bool
    {
        return false;
    }
}
