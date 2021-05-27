<?php

namespace App\Services;

use GuzzleHttp\Client;
use Str;

class GeocoderService
{

    public function getAddress($location, $language = 'ru-RU')
    {
        $client = new Client([
            'base_uri' => 'https://geocode-maps.yandex.ru/1.x/',
            'verify'   => false
        ]);
        $response = $client->get('?apikey=' . config('services.yandex.maps_api') . '&sco=latlong&format=json&geocode=' . $location . '&lang=' . $language);
        $data = json_decode($response->getBody(), true);
        return $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['description']
            . ', ' . $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name']; // TODO: XXX
    }
}
