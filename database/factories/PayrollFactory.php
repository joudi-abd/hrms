<?php

namespace Database\Factories;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payroll>
 */
class PayrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();
        $month = $this->faker->dateTimeThisYear();
        $month->setDate($month->format('Y'), $month->format('m'), 1);
        
        return [
            'employee_id' => $employee->id,
            'payroll_month' => $month,
            'paid_leaves' => $this->faker->numberBetween(0, 10),
            'unpaid_leaves' => $this->faker->numberBetween(0, 5),
            'gross_salary' => $this->faker->randomFloat(2, 1000, 10000),
            'deductions' => $this->faker->randomFloat(2, 0, 1000),
            'bonuses' => $this->faker->randomFloat(2, 0, 500),
            'net_salary' => $this->faker->randomFloat(2, 1000, 15000),
            'date_paid' => rand(0,1) ? Carbon::parse($month)->endOfMonth() : null,
        ];
    }
}
