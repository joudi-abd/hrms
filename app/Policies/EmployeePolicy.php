<?php

namespace App\Policies;

use App\Models\Employee;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('employees.view')||
                $employee->hasAbility('employees.view_department') ;
    }

    /**
     * Determine whether the user can view the model.
     */


    public function viewOwn(Employee $employee): bool
    {
        return $employee->hasAbility('employees.view_own');
    }
    public function view(Employee $employee , Employee $emp): bool
    {
        return $employee->hasAbility('employees.view') ||
               ($employee->hasAbility('employees.view_department') && $employee->department_id == $emp->department_id) ||
               ($employee->hasAbility('employees.view_own') && $employee->id == $emp->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('employees.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $employee, Employee $emp): bool
    {
        return $employee->hasAbility('employees.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $employee, Employee $emp): bool
    {
        return $employee->hasAbility('employees.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $employee, Employee $emp): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employee $employee, Employee $emp): bool
    {
        return false;
    }
}
