<?php declare(strict_types=1);

namespace Tests\Utils\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Utils\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomDigit(),
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'body' => $this->faker->words(asText: true),
        ];
    }
}
