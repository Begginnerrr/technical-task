<?php

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use App\Repository\ResolvedAddressRepository;

class CachedGoogleGeocoderAccess implements GeocoderAccessInterface
{
    public function useGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $geocoderCacheWriter = new GeocoderCacheWriter($resolvedAddressRepository);
        $geocoderCache = new GeocoderCacheFinder($resolvedAddressRepository);
        $googleMapsGeocoder = new GoogleMapsGeocoder();
        $returnedValue = $geocoderCache->findGeocoderCache($address);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        $returnedValue = $googleMapsGeocoder->geocode($address);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        return $returnedValue;
    }
}
