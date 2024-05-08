<?php

namespace App\Mailer;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Weather
{
    private const API_KEY = '63b8339f1895a016c3ee305c6b1762f9';
    private const API_URL = 'http://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getWeatherDataForCity(string $city): array
    {
        $apiUrl = sprintf(self::API_URL, urlencode($city), self::API_KEY);

        try {
            $response = $this->httpClient->request('GET', $apiUrl);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $weatherData = $response->toArray();

                // Ajouter les détails météorologiques supplémentaires
                $weatherDetails = $this->extractWeatherDetails($weatherData);
                $weatherData['weather_details'] = $weatherDetails;

                return $weatherData;
            } else {
                throw new \Exception("Erreur lors de la récupération des données météorologiques. Code de réponse : $statusCode");
            }
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération des données météorologiques : " . $e->getMessage());
        }
    }

    private function extractWeatherDetails(array $weatherData): array
    {
        // Extraire et formater les détails météorologiques supplémentaires
        $main = $weatherData['main'];
        $wind = $weatherData['wind'];
        $clouds = $weatherData['clouds'];

        return [
            'temperature' => $main['temp'] - 273.15,
            'humidity' => $main['humidity'],
            'pressure' => $main['pressure'],
            'visibility' => $weatherData['visibility'],
            'wind_speed' => $wind['speed'],
            'wind_direction' => $wind['deg'],
            'cloudiness' => $clouds['all'],
        ];
    }
}
