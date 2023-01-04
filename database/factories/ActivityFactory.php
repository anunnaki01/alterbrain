<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => 'Actividad '. microtime(true),
            'description' => $this->faker->text,
            'init_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date' => $this->faker->dateTimeBetween('now', '+05 days')->format('Y-m-d'),
            'price' => $this->faker->randomFloat(2, 100,500),
            'popularity' => $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
