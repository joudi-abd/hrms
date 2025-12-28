<?php

namespace App\Policies;

use App\Models\Employee;

class LeaveTypePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(Employee $employee)
    {
        return $employee->hasAbility('leave_types.view');
    }

    public function create(Employee $employee)
    {
        return $employee->hasAbility('leave_types.create');
    }

    public function update(Employee $employee)
    {
        return $employee->hasAbility('leave_types.edit');
    }

    public function delete(Employee $employee)
    {
        return $employee->hasAbility('leave_types.delete');
    }
    
}
