<?php

namespace App\domain\Brand\Repository;

use App\domain\Brand\Entity\Brand;
use App\domain\Tax\Repository\TaxRepository;

class BrandRepository
{
    private TaxRepository $taxRepository;

    // @OnlyForTest
    public function __construct(TaxRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }
    /**
     * @return Brand[]
     */
    public function findAll(): array
    {
        $tax1 = $this->taxRepository->find(1);
        $tax2 = $this->taxRepository->find(2);

        return [
            1 => new Brand(1, 'Farmitoo', $tax1),
            2 => new Brand(2, 'Gallagher', $tax2)
        ];
    }

    public function find(int $id): ?Brand
    {
        $brands = $this->findAll();

        if (isset($brands[$id])) {
            return $brands[$id];
        }

        return null;
    }
}
