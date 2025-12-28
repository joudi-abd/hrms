<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Report;
use App\Models\Role;
use App\Models\Task;
use App\Policies\AttendancePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\LeaveRequestPolicy;
use App\Policies\LeaveTypePolicy;
use App\Policies\RolePolicy;
use App\Policies\ReportPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [
        Employee::class => EmployeePolicy::class,
        Department::class => DepartmentPolicy::class,
        Role::class => RolePolicy::class,
        LeaveRequest::class => LeaveRequestPolicy::class,
        LeaveType::class => LeaveTypePolicy::class,
        Task::class => TaskPolicy::class,
        Attendance::class => AttendancePolicy::class,
        Report::class => ReportPolicy::class,
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Gate::before(function($user , $ability){
            if($user->super_admin){
                return true;
            }
        });
        // foreach (config('abilities') as $code => $label){
        //     Gate::define($code, function ($user) use ($code) {
        //         return $user->hasAbility($code);
        //     });
        // }
    }
}
