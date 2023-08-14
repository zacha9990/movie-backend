<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'image' => 'path/to/default/image.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
