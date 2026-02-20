<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalCopies = $this->faker->numberBetween(1, 20);
        return [
            'ISBN' => $this->faker->isbn13(),
            'title' => $this->faker->text(70),
            'price' => $this->faker->randomFloat(2, 0, 99),
            'mortgage' => $this->faker->randomFloat(2, 0, 9999),
            'authorship_date' => $this->faker->optional()->date(),

            'pages' => $this->faker->numberBetween(50, 1000),
            'borrow_duration' => $this->faker->numberBetween(7, 30), // 7-30 days
            'total_copies' => $totalCopies,
            'stock' => $this->faker->numberBetween(0, $totalCopies),

            'category_id' => Category::all()->random()->id
        ];
    }
}
