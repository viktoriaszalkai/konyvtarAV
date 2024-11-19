<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservations>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        	'user_id' => User::all()->random()->id,
            //jobbról nyitott intervallum
            'book_id' => Book::all()->random()->book_id,
            'start' => fake()->date(),
            //end direkt kihagyva, mert nullable
            'message'=> rand(0, 2)
        ];
    }
}
