<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200, 200),
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'category_id' => 1
        ];
    }
}
