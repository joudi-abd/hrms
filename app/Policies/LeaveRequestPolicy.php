<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\LeaveRequest;

class LeaveRequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(Employee $employee, $ability)
    {
        if ($employee->super_admin) {
            return true;
        }
    }

    public function viewAny(Employee $employee)
    {
        return $employee->hasAbility('leaves.view') ||
               $employee->hasAbility('leaves.view_department') ||
               $employee->hasAbility('leaves.view_own');
    }

    public function view(Employee $employee, LeaveRequest $leaveRequest)
    {
        return $employee->hasAbility('leaves.view') ||
               ($employee->hasAbility('leaves.view_department') && $leaveRequest->employee->department_id === $employee->department_id) ||
               ($employee->hasAbility('leaves.view_own') && $leaveRequest->employee_id === $employee->id);
    }

    public function create(Employee $employee)
    {
        return $employee->hasAbility('leaves.create');
    }

    public function update(Employee $employee, LeaveRequest $leaveRequest)
    {
        return $employee->hasAbility('leaves.edit') && $leaveRequest->employee_id === $employee->id;
    }
    public function delete(Employee $employee, LeaveRequest $leaveRequest)
    {
        return $employee->hasAbility('leaves.delete') && $leaveRequest->employee_id === $employee->id;
    }

    public function approve(Employee $employee, LeaveRequest $leaveRequest)
    {
        return $employee->hasAbility('leaves.approve');
    }

    public function reject(Employee $employee, LeaveRequest $leaveRequest)
    {
        return $employee->hasAbility('leaves.reject');
    }
}
