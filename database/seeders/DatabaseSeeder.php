<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Payroll;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RolesSeeder::class,
            LeaveTypesSeeder::class,
        ]);

        Department::factory()->create();
        Department::all()->each(function ($department) {
            $head = Employee::factory()->create();
            $department->head_id = $head->id;
            $department->save();
        });
        Department::factory()->create([
            'name' => 'Human Resources',
            'slug' => 'human-resources',
            'head_id' => Employee::factory()->create()->id,
            'description' => 'Handles recruitment, employee relations, and benefits.'
        ]);
        Employee::factory()->create([
            'name' => 'joudi',
            'email' => 'joudi@gmail.com',
            'password' => Hash::make('joudi12345'),
            'super_admin' => true,
        ]);
        Employee::factory(10)->create();
        
        LeaveRequest::factory(5)->create();
        Task::factory(15)->create();
        Payroll::factory(10)->create();
    }
}
