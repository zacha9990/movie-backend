<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Movie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class MovieControllerTest extends TestCase
{
    public function test_can_create_movie()
    {
        Storage::fake('image'); // Mock the image storage

        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => 'Test Movie',
            'description' => 'This is a test movie.',
            'rating' => 8.5,
            'image' => UploadedFile::fake()->image('movie.jpg'),
        ];

        $response = $this->postJson('/api/movies', $data);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Movie',
                'description' => 'This is a test movie.',
                'rating' => 8.5,
            ]);
    }


    public function test_can_get_movie()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        $movie = Movie::factory()->create();

        $response = $this->getJson('/api/movies/' . $movie->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $movie->id,
                'title' => $movie->title,
                'description' => $movie->description,
            ]);
    }

    public function test_can_update_movie()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        Storage::fake('image'); // Mock the image storage

        $movie = Movie::factory()->create();

        $data = [
            'title' => 'Updated Movie Title',
            'description' => 'Updated movie description.',
            'rating' => 9.0,
            'image' => UploadedFile::fake()->image('updated_movie.jpg'),
        ];

        $response = $this->putJson('/api/movies/' . $movie->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Movie Title',
                'description' => 'Updated movie description.',
                'rating' => 9.0,
            ]);
    }

    public function test_can_delete_movie()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        Storage::fake('image'); // Mock the image storage

        $movie = Movie::factory()->create();

        $response = $this->deleteJson('/api/movies/' . $movie->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Movie deleted']);

        Storage::disk('image')->assertMissing($movie->image);
    }

    public function test_cannot_update_nonexistent_movie()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        $data = [
            'title' => 'Updated Movie Title',
            'description' => 'Updated movie description.',
            'rating' => 9.0,
        ];

        $response = $this->putJson('/api/movies/999', $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Movie not found']);
    }

    public function test_cannot_delete_nonexistent_movie()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        $response = $this->deleteJson('/api/movies/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Movie not found']);
    }

    public function test_unauthorized_access_to_store()
    {
        $data = [
            'title' => 'Unauthorized Movie',
            'description' => 'Unauthorized movie description.',
            'rating' => 9.0,
            'image' => UploadedFile::fake()->image('unauthorized_movie.jpg'),
        ];

        $response = $this->postJson('/api/movies', $data);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_unauthorized_access_to_update()
    {
        $movie = Movie::factory()->create();

        $data = [
            'title' => 'Updated Movie Title',
            'description' => 'Updated movie description.',
            'rating' => 9.0,
        ];

        $response = $this->putJson('/api/movies/' . $movie->id, $data);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_validation_errors_on_store()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        $data = [
            'title' => 'Invalid Movie',
            // 'description' => 'Missing description.',
            'rating' => 11.0, // Invalid rating value
        ];

        $response = $this->postJson('/api/movies', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['description', 'rating']);
    }

    public function test_validation_errors_on_update()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);


        $movie = Movie::factory()->create();

        $data = [
            'title' => 'Updated Movie Title',
            // 'description' => 'Missing description.',
            'rating' => -1.0, // Invalid rating value
        ];

        $response = $this->putJson('/api/movies/' . $movie->id, $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['description', 'rating']);
    }
}
