<?php

namespace App\Service;

use App\ValueObject\Address;
use App\ValueObject\Coordinates;
use App\Repository\ResolvedAddressRepository;

interface GeocoderAccessInterface
{
    public function useGeocoder(Address $address, ResolvedAddressRepository $resolvedAddressRepository): ?Coordinates;
}
