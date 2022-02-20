<?php

namespace App\domain\Shipping\Repository;

use App\domain\Country\Entity\Country;
use App\domain\Shipping\Entity\Shipping;

class ShippingRepository
{
    /**
     * @return Shipping[]
     */
    public function findAll(): array
    {
        $france = new Country(1, 'France');

        return [
            1 => new Shipping(1, $france, 0, null, 0, 3, 2000),
            2 => new Shipping(2, $france, 0, null, 4, 6, 4000),
            3 => new Shipping(3, $france, 0, null, 7, 9, 6000),
            4 => new Shipping(4, $france, 0, null, 10, 12, 8000),
            5 => new Shipping(5, $france, 0, null, 13, 15, 10000),
            6 => new Shipping(6, $france, 0, null, 16, 18, 12000),
            7 => new Shipping(7, $france, 0, null, 0, null, 1500)
        ];
    }

    public function find(int $id): ?Shipping
    {
        $shipping = $this->findAll();

        if (isset($shipping[$id])) {
            return $shipping[$id];
        }

        return null;
    }
}
