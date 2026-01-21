<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
            public function run(): void
            {
                $faker = FakerFactory::create('id_ID');
                for ($i=0; $i < 10; $i++) {
                    Ticket::create([
                        'title' => $faker->sentence,
                        'description' => $faker->paragraph,
                        'category' => $faker->randomElement(['bug', 'feature_request', 'support']),
                        'priority' => $faker->randomElement(['low', 'medium', 'high']),
                        'status' => $faker->randomElement(['open', 'in_progress', 'closed']),
                        'reporter_id' => $faker->numberBetween(1, 10),
                        'assigned_to_id' => $faker->numberBetween(1, 10),
                        'assigned_team' => $faker->randomElement(['development', 'design', 'support']),
                        'date_reported' => $faker->dateTimeBetween('-1 month', 'now'),
                        'due_date' => $faker->dateTimeBetween('now', '+1 month'),
                        'resolved_date' => $faker->dateTimeBetween('now', '+2 months'),
                        'closed_date' => $faker->dateTimeBetween('now', '+3 months'),
                        'sla_breached' => $faker->boolean,
                        'response_time' => $faker->numberBetween(1, 100),
                        'resolution_time' => $faker->numberBetween(1, 100),
                        'estimated_effort' => $faker->numberBetween(1, 100),
                        'actual_effort' => $faker->numberBetween(1, 100),
                        'parent_ticket_id' => $faker->optional()->numberBetween(1, 10),
                        'converted_to_type' => $faker->optional()->randomElement(['bug', 'feature_request', 'support']),
                        'converted_to_id' => $faker->optional()->numberBetween(1, 10),
                        'converted_at' => $faker->optional()->dateTimeBetween('-15 days', 'now'),
                        'conversion_reason' => $faker->optional()->sentence,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
            }
}
