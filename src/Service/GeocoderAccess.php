<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use App\Service\GoogleMapsGeocoder;
use App\Repository\ResolvedAddressRepository;

class GeocoderAccess
{

    public function geocoderAccess(GeocoderAccessInterface $geocoderAccessInterface, Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        return $geocoderAccessInterface->useGeocoder($address, $resolvedAddressRepository);
    }
}
