<?php

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use App\Service\GeocoderCacheFinder;
use App\Repository\ResolvedAddressRepository;

class GeocoderCacheAccess implements GeocoderAccessInterface
{
    public function useGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $geocoderCache = new GeocoderCacheFinder($resolvedAddressRepository);
        return $geocoderCache->findGeocoderCache($address);
    }
}
