<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Confession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'confession_id' => Confession::factory(),
            'sender_type' => fake()->randomElement(['guest', 'user']),
            'message' => fake()->sentence(8),
            'is_read' => fake()->boolean(20),
        ];
    }
}
