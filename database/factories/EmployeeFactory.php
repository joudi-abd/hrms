<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->unique()->numerify('EMP-###'),
            'name' => $this->faker->name(),
            'department_id' => \App\Models\Department::factory(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'on_leave']),
            'job_title' => $this->faker->randomElement(['Manager' , 'Developer', 'Designer', 'QA', 'HR']),
            'hire_date' => $this->faker->date(),
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
        ];
    }
}
