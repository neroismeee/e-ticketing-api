<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'category' => 'hardware',
            'priority' => 'critical',
            'status' => 'waiting_for_user',
            'reporter_id' => User::factory(),
            'date_reported' => $this->faker->time('H:i:s', 'now')
        ];
    }
}
