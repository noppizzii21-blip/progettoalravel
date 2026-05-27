<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $access = $this->faker->randomElement(['free', 'presale', 'waiting_list', 'open']);
        $price = $access === 'presale' ? $this->faker->randomFloat(2, 10, 80) : null;

        return [
            'title' => $this->faker->catchPhrase(),
            'description' => $this->faker->paragraph(4),
            'city' => $this->faker->city(),
            'zone' => $this->faker->randomElement(['Downtown', 'Midtown', 'Harbor', 'Uptown']),
            'address' => $this->faker->streetAddress(),
            'date' => $this->faker->dateTimeBetween('+1 days', '+45 days'),
            'time' => $this->faker->time('H:i'),
            'min_age' => $this->faker->randomElement([18, 21, null]),
            'max_participants' => $this->faker->randomElement([50, 120, 250, null]),
            'access_type' => $access,
            'presale_price' => $price,
            'presale_quantity' => $price ? $this->faker->numberBetween(10, 100) : null,
            'status' => $this->faker->randomElement(['pending', 'published', 'rejected']),
        ];
    }
}
