<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\RoleAbility;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $allAbilities = [
            'employees.view','employees.view_own','employees.view_department','employees.create','employees.edit','employees.delete',
            'departments.view','departments.view_own','departments.create','departments.edit','departments.delete',
            'tasks.view','tasks.view_own','tasks.view_department','tasks.create','tasks.edit','tasks.change_status','tasks.delete',
            'leaves.view','leaves.view_own','leaves.view_department','leaves.create','leaves.edit','leaves.approve','leaves.reject','leaves.delete',
            'leave_types.view','leave_types.create','leave_types.edit','leave_types.delete',
            'payrolls.view','payrolls.view_own','payrolls.generate','payrolls.pay','payrolls.edit','payrolls.delete',
            'attendance.view','attendance.view_department','attendance.view_own','attendance.check_in','attendance.check_out','attendance.edit','attendance.delete','attendance.create_daily',
            'roles.view','roles.create','roles.edit','roles.delete',
            'reports.view','reports.export_pdf',
        ];
        // -----------------------------
        $admin = Role::updateOrCreate(
            ['name' => 'Admin']
        );
        $adminAbilities = [
            'employees.view','employees.create','employees.edit','employees.delete',
            'departments.view','departments.view_own','departments.create','departments.edit','departments.delete',
            'tasks.view','tasks.view_own','tasks.view_department','tasks.create','tasks.edit','tasks.change_status','tasks.delete',
            'leaves.view','leaves.view_own','leaves.view_department','leaves.create','leaves.edit','leaves.approve','leaves.reject','leaves.delete',
            'leave_types.view','leave_types.create','leave_types.edit','leave_types.delete',
            'payrolls.view','payrolls.view_own','payrolls.generate','payrolls.pay','payrolls.edit','payrolls.delete',
            'attendance.view','attendance.view_department','attendance.view_own','attendance.check_in','attendance.check_out','attendance.edit','attendance.delete','attendance.create_daily',
            'roles.view','roles.create','roles.edit','roles.delete',
            'reports.view','reports.export_pdf',
        ];

        foreach ($allAbilities as $ability) {
            $type = in_array($ability, $adminAbilities) ? 'allow' : 'deny';
            RoleAbility::updateOrCreate(
                ['role_id' => $admin->id, 'ability' => $ability],
                ['type' => $type] 
            );
        }

        // -----------------------------
        $hrManager = Role::updateOrCreate(
            ['name' => 'HR Manager']
        );

        $hrAbilities = [
            'employees.view','employees.view_department','employees.create','employees.edit',
            'departments.view','departments.create','departments.edit',
            'tasks.view','tasks.create','tasks.edit','tasks.change_status',
            'leaves.view','leaves.view_own','leaves.view_department','leaves.create','leaves.edit','leaves.approve','leaves.reject',
            'leave_types.view','leave_types.create','leave_types.edit',
            'payrolls.view','payrolls.view_own','payrolls.generate','payrolls.pay','payrolls.edit',
            'attendance.view','attendance.check_in','attendance.check_out','attendance.create_daily',
            'reports.view','reports.export_pdf',
        ];

        foreach ($allAbilities as $ability) {
            $type = in_array($ability, $hrAbilities) ? 'allow' : 'deny';
            RoleAbility::updateOrCreate(
                ['role_id' => $hrManager->id, 'ability' => $ability],
                ['type' => $type]
            );
        }

        // -----------------------------

        $headDept = Role::updateOrCreate(
            ['name' => 'Head Department']
        );

        $headDeptAbilities = [
            'employees.view_department',
            'departments.view_own',
            'tasks.view_department','tasks.create','tasks.edit','tasks.change_status','tasks.delete',
            'leaves.view_department','leaves.create','leaves.edit','leaves.approve','leaves.reject','tasks.delete',
            'payrolls.view_own',
            'attendance.view_department','attendance.check_in','attendance.check_out','attendance.create_daily',
        ];

        foreach ($allAbilities as $ability) {
            $type = in_array($ability, $headDeptAbilities) ? 'allow' : 'deny';
            RoleAbility::updateOrCreate(
                ['role_id' => $headDept->id, 'ability' => $ability],
                ['type' => $type]
            );
        }
        // -----------------------------
        $employee = Role::updateOrCreate(
            ['name' => 'Employee']
        );

        $employeeAbilities = [
            'employees.view_own',
            'departments.view_own',
            'tasks.view_own','tasks.change_status',
            'leaves.view_own','leaves.create','leaves.edit','leaves.delete',
            'payrolls.view_own',
            'attendance.view_own','attendance.check_in','attendance.check_out',
        ];

        foreach ($allAbilities as $ability) {
            $type = in_array($ability, $employeeAbilities) ? 'allow' : 'deny';
            RoleAbility::updateOrCreate(
                ['role_id' => $employee->id, 'ability' => $ability],
                ['type' => $type]
            );
        }

        $this->command->info('Roles and abilities seeded successfully!');
    }
}