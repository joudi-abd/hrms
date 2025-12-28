<?php

namespace App\Policies;

use App\Concerns\HasRoles;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Auth\Access\Response;

class PayrollPolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('payrolls.view')||
               $employee->hasAbility('payrolls.view_own');
    }

    public function viewAll(Employee $employee): bool
    {
        return $employee->hasAbility('payrolls.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employee $employee , Payroll $payroll): bool
    {
        return $employee->hasAbility('payrolls.view') ||
        ($employee->hasAbility('payrolls.view_own') && $employee->id === $payroll->employee_id);    }

    /**
     * Determine whether the user can create models.
     */
    public function generate(Employee $employee): bool
    {
        return $employee->hasAbility('payrolls.generate');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $employee, Payroll $payroll): bool
    {
        return $employee->hasAbility('payrolls.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $employee, Payroll $payroll): bool
    {
        return $employee->hasAbility('payrolls.delete');
    }

    public function pay(Employee $employee, Payroll $payroll): bool
    {
        return $employee->hasAbility('payrolls.pay');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $employee, Payroll $payroll): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employee $employee, Payroll $payroll): bool
    {
        return false;
    }
}
