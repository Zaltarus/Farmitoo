<?php

namespace App\domain\Product\Repository;

use App\domain\Brand\Repository\BrandRepository;
use App\domain\Product\Entity\Product;

class ProductRepository
{
    private BrandRepository $brandRepository;

    // @OnlyForTest
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        // @OnlyForTest
        $brandFarmitoo = $this->brandRepository->find(1);
        $brandGallagher = $this->brandRepository->find(2);

        return [
            1 => new Product(1, 'Cuve à gasoil', 250000, $brandFarmitoo),
            2 => new Product(2, 'Nettoyant pour cuve', 5000, $brandFarmitoo),
            3 => new Product(3, 'Piquet de clôture', 1000, $brandGallagher),
        ];
    }

    public function find(int $id): ?Product
    {
        $products = $this->findAll();

        if (isset($products[$id])) {
            return $products[$id];
        }

        return null;
    }
}
