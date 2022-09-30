<?php

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use App\Service\GoogleMapsGeocoder;
use App\Repository\ResolvedAddressRepository;

class GoogleGeocoderAccess implements GeocoderAccessInterface
{

    public function useGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $googleMapsGeocoder = new GoogleMapsGeocoder();
        return $googleMapsGeocoder->geocode($address);
    }
}
