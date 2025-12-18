<?php

namespace Database\Factories;

use App\Models\Confession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Confession>
 */
class ConfessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Confession::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'message' => fake()->paragraph(),
            'guest_token' => Str::random(64),
            'ip_address' => fake()->ipv4(),
            'is_read' => false,
        ];
    }
}
