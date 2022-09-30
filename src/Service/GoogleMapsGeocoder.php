<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use App\ValueObject\Address;
use App\ValueObject\Coordinates;

class GoogleMapsGeocoder implements GeocoderInterface
{

    public function geocode(Address $address): ?Coordinates
    {
        $returnedCoordinates = $this->googleMapsCall($address);
        if ($returnedCoordinates === null) {
            return null;
        }
        return new Coordinates($returnedCoordinates['lat'],  $returnedCoordinates['lng']);
    }

    private function googleMapsCall(Address $address): ?array
    {

        $country = $address->getCountry();
        $city = $address->getCity();
        $street = $address->getStreet();
        $postcode = $address->getPostcode();

        $apiKey = $_ENV["GOOGLE_GEOCODING_API_KEY"];

        $params = [
            'query' => [
                'address' => $street,
                'components' => implode('|', ["country:{$country}", "locality:{$city}", "postal_code:{$postcode}"]),
                'key' => $apiKey
            ]
        ];

        $client = new Client();

        $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', $params);

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($data['results']) === 0) {
            return null;
        }

        $firstResult = $data['results'][0];

        if ($firstResult['geometry']['location_type'] !== 'ROOFTOP') {
            return null;
        }

        return $firstResult['geometry']['location'];
    }
}
