<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;

abstract class BaseTestCase extends TestCase
{
    protected Authenticatable $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for testing
        $this->user = User::factory()->create();

        // Act as the user
        $this->actingAs($this->user);
    }
}
