<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\OpenWeatherService;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function getForecastByUser(User $user, OpenWeatherService $service)
    {
        $forecast = Cache::remember("user_{$user->id}_forecast", now()->addMinutes(60), function () use ($user, $service) {
            return $service->getForecastWeatherByUserCoords($user->latitude, $user->longitude);
        });

        return response()->json([
            'weather' => $forecast,
        ]);
    }
}
