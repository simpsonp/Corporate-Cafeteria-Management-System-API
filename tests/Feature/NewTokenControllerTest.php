<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NewTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing a new token with valid credentials.
     *
     * @return void
     */
    public function testStoreWithValidCredentials()
    {
        // Create a user with a known password
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        // Define the request payload
        $payload = [
            'email' => $user->email,
            'password' => 'password123',
            'token_name' => 'test-token'
        ];

        // Perform the POST request
        $response = $this->postJson('/api/users/tokens', $payload);

        // Assert that the response status is 200 OK
        $response->assertStatus(200);

        // Assert that the response contains a token
        $response->assertJsonStructure(['token']);

        // Verify that a token is created and returned
        $this->assertNotNull($response->json('token'));

        // Verify that the token exists in the database table
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'test-token',
            'tokenable_id' => $user->id
        ]);

        // Verify that the token is valid by making an authenticated request
        $token = $response->json('token');
        // Perform a GET request to the route with Bearer token header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/user');
        // Assert the response status is 200
        $response->assertStatus(200);
    }

    /**
     * Test storing a new token with invalid credentials.
     *
     * @return void
     */
    public function testStoreWithInvalidCredentials()
    {
        // Create a user with a known password
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        // Define the request payload with incorrect password
        $payload = [
            'email' => $user->email,
            'password' => 'wrongpassword',
            'token_name' => 'test-token'
        ];

        // Perform the POST request
        $response = $this->postJson('/api/users/tokens', $payload);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert that the response contains validation error for email
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Test storing a new token with missing fields.
     *
     * @return void
     */
    public function testStoreWithMissingFields()
    {
        // Define the request payload with missing fields
        $payload = [
            'email' => 'example@example.com',
            'password' => 'password123'
            // Missing 'token_name'
        ];

        // Perform the POST request
        $response = $this->postJson('/api/users/tokens', $payload);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert that the response contains validation error for token_name
        $response->assertJsonValidationErrors(['token_name']);
    }
}
