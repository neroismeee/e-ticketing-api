<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'role' => $faker->randomElement(['admin', 'team_lead', 'it_staff', 'reporter']),
                'team' => $faker->randomElement(['programmer', 'network', 'hardware']),
                'avatar' => $faker->imageUrl(100, 100, 'people'),
                'is_active' => $faker->boolean,
                'last_login' => $faker->dateTimeBetween('-1 month', 'now'),
                'created_at' => now(),
                'pref_dark_mode' => $faker->boolean,
                'pref_email_notifications' => $faker->boolean,
                'pref_sla_alerts' => $faker->boolean,
                'pref_downtime_alerts' => $faker->boolean,
                'pref_digest_frequency' => $faker->randomElement(['immediate', 'hourly', 'daily', 'weekly']),
                'pref_quiet_hours' => $faker->optional()->time('H:i') . '-' . $faker->optional()->time('H:i'),
            ]);
        }
    }
}
