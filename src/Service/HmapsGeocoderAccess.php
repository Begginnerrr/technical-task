<?php

namespace App\Service;

use App\ValueObject\Address;
use App\Service\HmapsGeocoder;
use App\ValueObject\Coordinates;
use App\Repository\ResolvedAddressRepository;

class HmapsGeocoderAccess implements GeocoderAccessInterface
{
    public function useGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $hMapsGeocoder = new HmapsGeocoder();
        return $hMapsGeocoder->geocode($address);
    }
}
