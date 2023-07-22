<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_the_users_view_can_be_rendered()
    {
        // Arrange
        $users = User::factory(20)->create();

        // Act
        $response = $this->withoutExceptionHandling()->get('/users');

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('users', $users);
    }
}
