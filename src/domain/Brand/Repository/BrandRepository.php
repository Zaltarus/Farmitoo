<?php

namespace App\domain\Brand\Repository;

use App\domain\Brand\Entity\Brand;
use App\domain\Shipping\Repository\ShippingRepository;
use App\domain\Tax\Repository\TaxRepository;
use Doctrine\Common\Collections\ArrayCollection;

class BrandRepository
{
    private TaxRepository $taxRepository;

    private ShippingRepository $shippingRepository;

    // @OnlyForTest
    public function __construct(TaxRepository $taxRepository, ShippingRepository $shippingRepository)
    {
        $this->taxRepository = $taxRepository;
        $this->shippingRepository = $shippingRepository;
    }
    /**
     * @return Brand[]
     */
    public function findAll(): array
    {
        $tax1 = $this->taxRepository->find(1);
        $tax2 = $this->taxRepository->find(2);

        $shippings = [
            $this->shippingRepository->find(1),
            $this->shippingRepository->find(2),
            $this->shippingRepository->find(3),
            $this->shippingRepository->find(4),
            $this->shippingRepository->find(5),
            $this->shippingRepository->find(6),
        ];

        return [
            1 => new Brand(1, 'Farmitoo', $tax1, new ArrayCollection($shippings)),
            2 => new Brand(2, 'Gallagher', $tax2, new ArrayCollection([$this->shippingRepository->find(7)])),
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
