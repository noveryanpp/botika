<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Division;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeJob>
 */
class EmployeeJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'position_id' => Position::inRandomOrder()->first()->id,
            'division_id' => Division::inRandomOrder()->first()->id,
            'salary' => $this->faker->randomFloat(2, 1000000, 15000000),
        ];
    }
}
