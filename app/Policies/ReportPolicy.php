<?php

namespace App\Policies;

use App\Models\Employee;

class ReportPolicy
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

    public function viewAny(Employee $employee )
    {
        return $employee->hasAbility('reports.view');
    }

    public function export(Employee $employee )
    {
        return $employee->hasAbility('reports.export_pdf');
    }

}
