<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(5)->create()->each(function (User $user) {
            $user->update([
                'handler' => fake()->unique()->userName(),
                'description' => fake()->sentence(8),
            ]);

            foreach (range(1, fake()->numberBetween(3, 6)) as $sort) {
                Link::factory()->for($user)->create(['sort' => $sort]);
            }
        });
    }
}
