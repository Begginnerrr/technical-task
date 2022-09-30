<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use GuzzleHttp\Client;
 
class HmapsGeocoder implements GeocoderInterface {

    public function geocode(Address $address): ?Coordinates
    {
        
        $returnedCoordinates = $this->hmapsCall($address);
        $this->debug_to_console($returnedCoordinates);
        if($returnedCoordinates === null){
            return null;
        }
        return new Coordinates($returnedCoordinates['lat'],$returnedCoordinates['lng']);
    }

    private function hmapsCall(Address $address) : ?array
    {
        $country =  $address->getCountry();
        $city = $address->getCity();
        $street =  $address->getStreet();
        $postcode =  $address->getPostcode();
        $apiKey = $_ENV["HEREMAPS_GEOCODING_API_KEY"];

        $params = [
            'query' => [
                'qq' => implode(';', ["country={$country}", "city={$city}", "street={$street}", "postalCode={$postcode}"]),
                'apiKey' => $apiKey
            ]
        ];

        $client = new Client();

        $response = $client->get('https://geocode.search.hereapi.com/v1/geocode', $params);

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($data['items']) === 0) {
            return null;
        }

        $firstItem = $data['items'][0];

        if ($firstItem['resultType'] !== 'houseNumber') {
            return null;
        }

        # return new JsonResponse($firstItem['position']);
        return $firstItem['position'];
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

}
