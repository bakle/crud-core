<?php declare(strict_types=1);

namespace Tests\Utils\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Utils\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;
    public function definition(): array
    {
        return [
            'id' => $this->faker->randomDigit(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => bcrypt('password'),
        ];
    }
}
