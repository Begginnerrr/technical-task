<?php

namespace App\Service;

use App\Repository\ResolvedAddressRepository;
use App\ValueObject\Address;
use App\ValueObject\Coordinates;


class GeocoderCacheWriter
{

    private ResolvedAddressRepository $resolvedAddressRepository;

    function __construct(ResolvedAddressRepository $resolvedAddressRepository)
    {
        $this->resolvedAddressRepository = $resolvedAddressRepository;
    }

    public function recordGeocoderData(Address $address, Coordinates $coordinates): void
    {
        $this->resolvedAddressRepository->saveResolvedAddress($address, $coordinates);
    }
}
