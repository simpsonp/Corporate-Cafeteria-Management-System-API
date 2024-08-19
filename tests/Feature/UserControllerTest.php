<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the showCurrent method of the UserController.
     *
     * @return void
     */
    public function testShowCurrent()
    {
        // Create a user for testing
        /** @var \Illuminate\Contracts\Auth\Authenticatable */
        $user = User::factory()->create();

        // Act as the user
        $response = $this->actingAs($user)->get('/api/user');

        // Assert the response status is 200
        $response->assertStatus(200);

        // Assert the response contains the correct user data
        $response->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
