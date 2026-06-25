<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'device' => fake()->randomElement(['mobile', 'desktop']),
            'referer' => fake()->optional()->domainName(),
            'ip_hash' => fake()->sha256(),
        ];
    }
}
