<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tasks>
 */
class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'owner' => $faker->name,
            'todo' => $this->faker->paragraph(),
            'status' => ['0','1'][rand(0,1)],
            'category' => ['School', 'Work', 'Sport', 'Family'][rand(0,3)],
        ];
    }
}
