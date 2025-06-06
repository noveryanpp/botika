<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Division;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'division_id' => Division::inRandomOrder()->first()->id,
        ];
    }
}
