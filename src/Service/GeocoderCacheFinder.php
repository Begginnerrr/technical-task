<?php

namespace App\Service;

use App\Entity\ResolvedAddress;
use App\Repository\ResolvedAddressRepository;
use App\ValueObject\Address;
use App\ValueObject\Coordinates;

class GeocoderCacheFinder
{

    private ResolvedAddressRepository $resolvedAddressRepository;

    function __construct(ResolvedAddressRepository $resolvedAddressRepository)
    {
        $this->resolvedAddressRepository = $resolvedAddressRepository;
    }

    public function findGeocoderCache(Address $address): ?Coordinates
    {
        $returnedResolvedAdress = new ResolvedAddress();
        $returnedResolvedAdress = $this->resolvedAddressRepository->getByAddress($address);

        if (!empty($returnedResolvedAdress)) {
            return new Coordinates($returnedResolvedAdress->getlat(), $returnedResolvedAdress->getlng());
        } else {
            return null;
        }
    }
}
