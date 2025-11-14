<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ApiTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user
        $this->user = User::factory()->create();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_login_and_receive_token()
    {
        // Attempt to login and get the token
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password', // Assuming this is the password set in factory
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'token']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_cannot_access_protected_routes_without_token()
    {
        // Trying to access a protected route without authentication
        $response = $this->getJson('/api/movies');

        // Assert 401 Unauthorized response
        $response->assertStatus(401);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function authenticated_user_can_crud_movies()
    {
        // Authenticate user and get token
        $token = $this->user->createToken('TestApp');
        $tokenString = $token->plainTextToken;

        $headers = ['Authorization' => 'Bearer ' . $tokenString];

        // Create a new movie
        $response = $this->postJson('/api/movies', [
            'title' => 'Test Movie',
            'director' => 'Test Director',
            'duration' => 120,
            'release_date' => '2025-01-01',
            'description' => 'Test description',
        ], $headers);

        $response->assertStatus(201)
                 ->assertJson(['title' => 'Test Movie']);

        // Try to read the created movie
        $response = $this->getJson('/api/movies', $headers);

        $response->assertStatus(200)
                 ->assertJsonStructure([['title', 'director']]);

        // Try to update the movie
        $movie = $response->json()[0]; // Assuming we got the first movie
        $response = $this->putJson("/api/movies/{$movie['id']}", [
            'title' => 'Updated Movie',
            'director' => 'Updated Director',
            'duration' => 130,
            'release_date' => '2025-01-02',
            'description' => 'Updated description',
        ], $headers);

        $response->assertStatus(200)
                 ->assertJson(['title' => 'Updated Movie']);

        // Delete the movie
        $response = $this->deleteJson("/api/movies/{$movie['id']}", [], $headers);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Movie deleted successfully']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_logout()
    {
        // Authenticate user and get token
        $token = $this->user->createToken('TestApp');
        $tokenString = $token->plainTextToken;

        $headers = ['Authorization' => 'Bearer ' . $tokenString];

        // Make a logout request
        $response = $this->postJson('/api/logout', [], $headers);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out successfully']);
    }
}
