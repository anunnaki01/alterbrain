<?php

namespace Database\Factories;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityBooking>
 */
class ActivityBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'activity_id' => function () {
                return Activity::factory()->create()->id;
            },
            'number_people' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9]),
            'price' => $this->faker->randomFloat(2),
            'activity_date' => Carbon::now()->format('Y-m-d'),
        ];
    }
}
