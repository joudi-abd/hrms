<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(1, true);
        return [
            'name' => $name,
            'slug' => \Str::slug($name),
            'head_id' => null, // Assuming head_id can be null initially
            'description' => $this->faker->sentence(10),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
