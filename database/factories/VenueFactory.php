<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Venue>
 */
class VenueFactory extends Factory
{
    protected $model = Venue::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Club',
            'description' => $this->faker->paragraph(3),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'zone' => $this->faker->randomElement(['Downtown', 'Midtown', 'East Side', 'West End']),
            'postal_code' => $this->faker->postcode(),
            'capacity' => $this->faker->numberBetween(80, 1200),
            'image' => null,
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'status' => $this->faker->randomElement(['approved', 'pending', 'rejected']),
        ];
    }
}
