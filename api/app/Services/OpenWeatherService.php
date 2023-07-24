<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class OpenWeatherService
{
    private $api_key = null;

    private $api_endpoint_forecast = null;

    private $api_endpoint_icons = null;

    private $api_endpoint_icons_ext = null;

    private $api_endpoint_onecall = null;

    private $api_lang = null;

    private $format_date = null;

    private $format_time = null;

    private $format_units = null;

    private $format_day = null;

    public function __construct()
    {
        $this->api_key = Config::get('openweather.api_key');
        $this->api_endpoint_forecast = Config::get('openweather.api_endpoint_forecast');
        $this->api_endpoint_onecall = Config::get('openweather.api_endpoint_onecall');

        $this->api_endpoint_icons = Config::get('openweather.api_endpoint_icons');
        $this->api_endpoint_icons_ext = Config::get('openweather.api_endpoint_icons_ext');
        $this->api_lang = Config::get('openweather.api_lang');
        $this->format_date = Config::get('openweather.format_date');
        $this->format_time = Config::get('openweather.format_time');
        $this->format_day = Config::get('openweather.format_day');
    }

    /**
     * Returns forecast weather by latitude and longitude.
     * Returns FALSE on failure.
     *
     * @param  string  $latitude Latitude
     * @param  string  $longitude Longitude
     * @param  string  $units Units of measurement (imperial, metric, kelvin)
     * @return array|bool
     */
    public function getForecastWeatherByUserCoords(string $latitude, string $longitude, string $units = 'imperial')
    {
        $this->format_units = $units;

        return $this->getOnecallWeather([
            'lat' => $latitude,
            'lon' => $longitude,
            'exclude' => 'minutely,hourly',
            'units' => $units,
            'lang' => $this->api_lang,
            'appid' => $this->api_key,
        ]);
    }

    /**
     * Returns an OpenWeather API response for forecast weather.
     * Returns FALSE on failure.
     *
     * @param  array  $params Array of request parameters.
     * @return array|bool
     */
    private function getForecastWeather(array $params)
    {
        $params = http_build_query($params);
        $request = $this->api_endpoint_forecast.$params;
        $response = $this->doRequest($request);
        if (! $response) {
            return false;
        }
        $response = $this->parseForecastResponse($response);
        if (! $response) {
            return false;
        }

        return $response;
    }

    /**
     * Parses and returns an OpenWeather forecast weather API response as an array of formatted values.
     * Returns FALSE on failure.
     *
     * @param  string  $response OpenWeather API response JSON.
     * @return array|bool
     */
    private function parseForecastResponse(string $response)
    {
        $struct = json_decode($response, true);
        if (! isset($struct['cod']) || $struct['cod'] != 200) {
            Log::error('OpenWeather - Error parsing forecast response.');

            return false;
        }

        $forecast = [];
        foreach ($struct['list'] as $item) {
            $forecast[] = [
                'datetime' => [
                    'timestamp' => $item['dt'],
                    'timestamp_sunrise' => $struct['city']['sunrise'],
                    'timestamp_sunset' => $struct['city']['sunset'],
                    'formatted_date' => date($this->format_date, $item['dt']),
                    'formatted_day' => date($this->format_day, $item['dt']),
                    'formatted_time' => date($this->format_time, $item['dt']),
                    'formatted_sunrise' => date($this->format_time, $struct['city']['sunrise']),
                    'formatted_sunset' => date($this->format_time, $struct['city']['sunset']),
                ],
                'condition' => [
                    'id' => $item['weather'][0]['id'],
                    'name' => $item['weather'][0]['main'],
                    'desc' => $item['weather'][0]['description'],
                    'icon' => $this->api_endpoint_icons.$item['weather'][0]['icon'].'@2x.'.$this->api_endpoint_icons_ext,
                ],
                'wind' => [
                    'speed' => $item['wind']['speed'],
                    'deg' => $item['wind']['deg'],
                    'direction' => $this->getDirection($item['wind']['deg']),
                ],
                'forecast' => [
                    'temp' => round($item['main']['temp']),
                    'temp_min' => round($item['main']['temp_min']),
                    'temp_max' => round($item['main']['temp_max']),
                    'pressure' => round($item['main']['pressure']),
                    'humidity' => round($item['main']['humidity']),
                ],
            ];
        }

        return [
            'formats' => [
                'lang' => $this->api_lang,
                'date' => $this->format_date,
                'day' => $this->format_day,
                'time' => $this->format_time,
                'units' => $this->format_units,
            ],
            'location' => [
                'id' => (isset($struct['city']['id'])) ? $struct['city']['id'] : 0,
                'name' => $struct['city']['name'],
                'country' => $struct['city']['country'],
                'latitude' => $struct['city']['coord']['lat'],
                'longitude' => $struct['city']['coord']['lon'],
            ],
            'forecast' => $forecast,
        ];
    }

    /**
     * Returns an OpenWeather API response for onecall weather.
     * Returns FALSE on failure.
     *
     * @param  array  $params Array of request parameters.
     * @return array|bool
     */
    private function getOnecallWeather(array $params)
    {
        $params = http_build_query($params);
        $request = $this->api_endpoint_onecall.$params;
        $response = $this->doRequest($request);
        if (! $response) {
            return false;
        }
        $response = $this->parseOnecallResponse($response);
        if (! $response) {
            return false;
        }

        return $response;
    }

    private function parseOnecallResponse(string $response)
    {
        $struct = json_decode($response, true);
        if (! isset($struct['cod']) || $struct['cod'] != 200) {
            // @TODO right now there is no cod element to check in the API response
        }

        $current = [];
        if (isset($struct['current'])) {
            $current['datetime'] = [
                'timestamp' => $struct['current']['dt'],
                'formatted_date' => date($this->format_date, $struct['current']['dt']),
                'formatted_day' => date($this->format_day, $struct['current']['dt']),
                'formatted_time' => date($this->format_time, $struct['current']['dt']),
            ];
            $current['condition'] = [
                'id' => $struct['current']['weather'][0]['id'],
                'name' => $struct['current']['weather'][0]['main'],
                'desc' => $struct['current']['weather'][0]['description'],
                'icon' => $this->api_endpoint_icons.$struct['current']['weather'][0]['icon'].'.'.$this->api_endpoint_icons_ext,
            ];
            $current['wind'] = [
                'speed' => $struct['current']['wind_speed'],
                'deg' => $struct['current']['wind_deg'],
                'direction' => $this->getDirection($struct['current']['wind_deg']),
            ];
            $current['forecast'] = [
                'temp' => round($struct['current']['temp']),
                'pressure' => round($struct['current']['pressure']),
                'humidity' => round($struct['current']['humidity']),
            ];
        }

        $daily = [];
        if (isset($struct['daily'])) {
            foreach ($struct['daily'] as $item) {
                $daily[] = [
                    'datetime' => [
                        'timestamp' => $item['dt'],
                        'timestamp_sunrise' => $item['sunrise'],
                        'timestamp_sunset' => $item['sunset'],
                        'formatted_date' => date($this->format_date, $item['dt']),
                        'formatted_day' => date($this->format_day, $item['dt']),
                        'formatted_time' => date($this->format_time, $item['dt']),
                        'formatted_sunrise' => date($this->format_time, $item['sunrise']),
                        'formatted_sunset' => date($this->format_time, $item['sunset']),
                    ],
                    'condition' => [
                        'id' => $item['weather'][0]['id'],
                        'name' => $item['weather'][0]['main'],
                        'desc' => $item['weather'][0]['description'],
                        'icon' => $this->api_endpoint_icons.$item['weather'][0]['icon'].'@2x.'.$this->api_endpoint_icons_ext,
                    ],
                    'wind' => [
                        'speed' => $item['wind_speed'],
                        'deg' => $item['wind_deg'],
                        'direction' => $this->getDirection($item['wind_deg']),
                    ],
                    'forecast' => [
                        'temp' => round($item['temp']['day']),
                        'temp_min' => round($item['temp']['min']),
                        'temp_max' => round($item['temp']['max']),
                        'pressure' => round($item['pressure']),
                        'humidity' => round($item['humidity']),
                    ],
                ];
            }
            $forecast['daily'] = $daily;
        }

        return [
            'formats' => [
                'lang' => $this->api_lang,
                'date' => $this->format_date,
                'day' => $this->format_day,
                'time' => $this->format_time,
                'units' => $this->format_units,
            ],
            'location' => [
                'latitude' => $struct['lat'],
                'longitude' => $struct['lon'],
            ],
            'current' => $current,
            'daily' => $daily,
        ];
    }

    /**
     * Performs an API request and returns the response.
     * Returns FALSE on failure.
     *
     * @param  string  $url Request URI
     * @return string|bool
     */
    private function doRequest(string $url)
    {
        $response = @file_get_contents($url);
        if (! $response) {
            Log::error('OpenWeather - Error fetching response from '.$url);

            return false;
        }

        return $response;
    }

    /**
     * Calculates the textual compass direction from a bearing in degrees.
     * Returns a cardinal compass direction on success and an empty string
     * on failure.
     */
    private function getDirection(int $degrees): string
    {
        $direction = '';
        $cardinal = [
            'N' => [337.5, 22.5],
            'NE' => [22.5, 67.5],
            'E' => [67.5, 112.5],
            'SE' => [112.5, 157.5],
            'S' => [157.5, 202.5],
            'SW' => [202.5, 247.5],
            'W' => [247.5, 292.5],
            'NW' => [292.5, 337.5],
        ];
        foreach ($cardinal as $dir => $angles) {
            if ($degrees >= $angles[0] && $degrees < $angles[1]) {
                $direction = $dir;
                break;
            }
        }

        return $direction;
    }
}
