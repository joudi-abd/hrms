<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Annual Leave',
                'max_days_per_year' => 21,
                'description' => 'Paid annual leave for employees.',
                'is_paid' => 1
            ],
            [
                'name' => 'Sick Leave',
                'max_days_per_year' => 10,
                'description' => 'Paid leave for sickness.',
                'is_paid' => 1
            ],
            [
                'name' => 'Maternity Leave',
                'max_days_per_year' => 90,
                'description' => 'Paid maternity leave.',
                'is_paid' => 1
            ],
            [
                'name' => 'Paternity Leave',
                'max_days_per_year' => 15,
                'description' => 'Paid paternity leave.',
                'is_paid' => 1
            ],
            [
                'name' => 'Unpaid Leave',
                'max_days_per_year' => 30,
                'description' => 'Leave without pay.',
                'is_paid' => 0
            ],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::updateOrCreate(
                ['name' => $type['name']],
                [
                    'max_days_per_year' => $type['max_days_per_year'],
                    'description' => $type['description'],
                    'is_paid' => $type['is_paid']
                ]
            );
        }

        $this->command->info('Default leave types have been seeded.');
    }
}
