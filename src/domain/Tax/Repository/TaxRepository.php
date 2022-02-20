<?php

namespace App\domain\Tax\Repository;

use App\domain\Tax\Entity\Tax;

class TaxRepository
{
    /**
     * @return Tax[]
     */
    public function findAll(): array
    {
        return [
            1 => new Tax(1, 2000),
            2 => new Tax(2, 500)
        ];
    }

    public function find(int $id): ?Tax
    {
        $tax = $this->findAll();

        if (isset($tax[$id])) {
            return $tax[$id];
        }

        return null;
    }
}
