<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use App\Service\GoogleMapsGeocoder;
use App\Repository\ResolvedAddressRepository;

class GeocoderAccess
{
    public function useGoogleGeocoder(Address $address): ?Coordinates
    {
        $googleMapsGeocoder = new GoogleMapsGeocoder();
        return $googleMapsGeocoder->geocode($address);
    }

    public function useHmapsGeocoder(Address $address): ?Coordinates
    {
        $hMapsGeocoder = new HmapsGeocoder();
        return $hMapsGeocoder->geocode($address);
    }

    public function useGeocoderCache(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $geocoderCache = new GeocoderCacheFinder($resolvedAddressRepository);
        return $geocoderCache->findGeocoderCache($address);
    }

    public function useFullStack(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $geocoderCacheWriter = new GeocoderCacheWriter($resolvedAddressRepository);
        $returnedValue = $this->useGeocoderCache($address, $resolvedAddressRepository);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        $returnedValue = $this->useGoogleGeocoder($address);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        $returnedValue = $this->useHmapsGeocoder($address);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        return $returnedValue;
    }

    public function useCachedGoogleGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $geocoderCacheWriter = new GeocoderCacheWriter($resolvedAddressRepository);
        $returnedValue = $this->useGeocoderCache($address, $resolvedAddressRepository);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        $returnedValue = $this->useGoogleGeocoder($address);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        return $returnedValue;
    }
    public function useCachedHMapsGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates
    {
        $geocoderCacheWriter = new GeocoderCacheWriter($resolvedAddressRepository);
        $returnedValue = $this->useGeocoderCache($address, $resolvedAddressRepository);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        $returnedValue = $this->useHmapsGeocoder($address);
        if (!empty($returnedValue)) {
            $geocoderCacheWriter->recordGeocoderData($address, $returnedValue);
            var_dump($returnedValue);
            return $returnedValue;
        }
        return $returnedValue;
    }
}
