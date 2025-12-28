<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();
        $leaveType = LeaveType::inRandomOrder()->first();
        $start = Carbon::now()->startOfMonth()->addDays(rand(0, 20));
        $days = rand(1, 5);
        $end = (clone $start)->addDays($days - 1);
        
        return [
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'total_days' => $days,
            'reason' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'approved_by' => null,
        ];
    }
}
