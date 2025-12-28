<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'department_id' => \App\Models\Department::factory(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'description' => $this->faker->sentence(8),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'assigned_to' => \App\Models\Employee::factory(),
            'created_by' => \App\Models\Employee::factory(),
            'start_date' => $this->faker->date(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'completed_at' => null,
        ];
    }
}
