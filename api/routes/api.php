<?php

use App\Models\User;
use App\Services\OpenWeatherService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'all systems are a go',
        'users' => \App\Models\User::all(),
    ]);
});

Route::get('users', function () {
});

Route::get('forecast/{user}', function (User $user, OpenWeatherService $service) {
    dd($service->getForecastWeatherByUserCoords($user->latitude, $user->longitude));
});
