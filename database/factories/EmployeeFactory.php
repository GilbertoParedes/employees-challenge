<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'job_position' => $this->faker->text($maxNbChars = 20),
            'birth_date' => Carbon::create( $this->faker->year(), $this->faker->month(), $this->faker->dayOfMonth())->format('Y-m-d'),
            'address' => $this->faker->country(),
        ];
    }
}
