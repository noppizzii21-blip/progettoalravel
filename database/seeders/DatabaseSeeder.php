<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $approver = User::factory()->create([
            'name' => 'Approver Admin',
            'email' => 'approver@example.com',
            'role' => 'approver',
        ]);

        $organizer = User::factory()->create([
            'name' => 'Event Organizer',
            'email' => 'organizer@example.com',
            'role' => 'organizer',
        ]);

        $venueOwner = User::factory()->create([
            'name' => 'Venue Owner',
            'email' => 'venue@example.com',
            'role' => 'venue_owner',
        ]);

        $guest = User::factory()->create([
            'name' => 'Nightlife Fan',
            'email' => 'user@example.com',
            'role' => 'user',
        ]);

        $venues = Venue::factory()
            ->count(2)
            ->state(fn () => ['user_id' => $venueOwner->id, 'status' => 'approved'])
            ->create();

        Event::factory()
            ->count(3)
            ->state(['status' => 'published'])
            ->for($organizer, 'organizer')
            ->for($venues->random(), 'venue')
            ->create();

        Event::factory()
            ->count(2)
            ->state(['status' => 'pending'])
            ->for($organizer, 'organizer')
            ->for($venues->random(), 'venue')
            ->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);
    }
}
