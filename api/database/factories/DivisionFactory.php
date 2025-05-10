<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        $divisions = [
            'Engineering',
            'Marketing',
            'Human Resources',
            'Finance',
            'Sales',
            'IT Support',
            'Operations',
            'Customer Service',
            'Product Development',
            'Legal'
        ];

        return [
            'name' => $this->faker->randomElement($divisions),
        ];
    }
}
