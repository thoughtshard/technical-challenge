<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Collector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Collector>
 */
final class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'title' => $this->faker->sentence(),
            'collector_id' => Collector::factory(),
            'isbn' => $this->faker->isbn13(),
            'type' => $this->faker->randomElement([
                'Fiction',
                'Non-Fiction',
                'Technical',
                'Self-Help',
            ]),
        ];
    }
}
