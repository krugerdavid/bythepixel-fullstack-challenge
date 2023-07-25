<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_the_users_view_can_be_rendered()
    {
        // Arrange
        $users = User::factory(20)->create();
        $userResources = UserResource::collection(User::all());
        $request = Request::create('/users', 'GET');

        // Act
        $response = $this->getJson('/users');

        // Assert
        $response->assertStatus(200)->assertJson(
            $userResources->response($request)->getData(true)
        );
    }
}
