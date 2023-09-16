<?php declare(strict_types=1);

namespace Tests\Utils\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Utils\Models\Comment;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomDigit(),
            'body' => $this->faker->words(asText: true),
        ];
    }
}
