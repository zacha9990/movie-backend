<?php

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        Movie::factory()->count(10)->create(); // Creates 10 movie records
    }
}
