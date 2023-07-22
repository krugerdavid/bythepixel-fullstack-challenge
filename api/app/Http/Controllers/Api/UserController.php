<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\OpenWeatherService;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function getForecastWeather($user, OpenWeatherService $service)
    {
        return $service->getForecastWeatherByUserCoords($user->latitude, $user->longitude);
    }
}
