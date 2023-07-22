<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\OpenWeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpenWeatherAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_weather_api_is_fetched()
    {
        // Arrange
        $user = User::factory()->create();
        $weatherService = app(OpenWeatherService::class);

        // Act
        $forecast = $weatherService->getForecastWeatherByUserCoords($user->latitude, $user->longitude);

        // Assert
        $this->assertArrayHasKey('location', $forecast);
    }
}
