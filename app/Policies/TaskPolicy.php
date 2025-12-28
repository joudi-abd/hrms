<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function before(Employee $employee, $ability)
    {
        if ($employee->super_admin) {
            return true;
        }
    }

    public function viewAll(Employee $employee): bool
    {
        return $employee->hasAbility('tasks.view');
    }
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('tasks.view')||
               $employee->hasAbility('tasks.view_own')||
               $employee->hasAbility('tasks.view_department');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employee $employee, Task $task): bool
    {
        return $employee->hasAbility('tasks.view')||
               ($employee->hasAbility('tasks.view_own') && $task->assigned_to == $employee->id)||
               ($employee->hasAbility('tasks.view_department') && $employee->department_id == $task->department_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('tasks.create') ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $employee, Task $task): bool
    {
        return $employee->hasAbility('tasks.edit') ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $employee, Task $task): bool
    {
        return $employee->hasAbility('tasks.delete') ;
    }

    public function changeStatus(Employee $employee, Task $task): bool
    {
        return $employee->hasAbility('tasks.change_status');
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $employee, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employee $employee, Task $task): bool
    {
        return false;
    }
}
