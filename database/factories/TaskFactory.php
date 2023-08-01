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
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'status' => fake()->randomElement(['Incomplete', 'In Progress', 'Completed']),
            'priority' => fake()->randomElement([1, 2, 3]),
            'start' => fake()->date(),
            'end' => fake()->date(),
            'description' => fake()->text(),
        ];
    }
}
