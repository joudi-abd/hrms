<?php

namespace App\Policies;

use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
use App\Models\Employee;

class AttendancePolicy
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

    public function view(Employee $employee , Attendance $attendance): bool
    {
        return $employee->hasAbility('attendance.view') ||
               ($employee->hasAbility('attendance.view_own') && $attendance->employee_id === $employee->id) ||
               ($employee->hasAbility('attendance.view_department') && $attendance->employee->department_id === $employee->department_id);
    }


    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('attendance.view') ||
               $employee->hasAbility('attendance.view_department') ||
               $employee->hasAbility('attendance.view_own');
    }

    public function checkIn(Employee $employee): bool
    {
        return $employee->hasAbility('attendance.check_in');
    }

    public function checkOut(Employee $employee, Attendance $attendance): bool
    {
        return $employee->hasAbility('attendance.check_out') && $attendance->employee_id === $employee->id;
    }

    public function update(Employee $employee): bool
    {
        return $employee->hasAbility('attendance.edit');
    }

    public function delete(Employee $employee): bool
    {
        return $employee->hasAbility('attendance.delete');
    }

    public function createDaily(Employee $employee): bool
    {
        return $employee->hasAbility('attendance.create_daily');
    }
}
