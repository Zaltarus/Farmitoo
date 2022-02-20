<?php

namespace App\domain\Product\Entity;

use App\domain\Brand\Entity\Brand;

class Product
{
    private int $id;

    private string $title;

    private int $priceHT;

    private Brand $brand;

    public function __construct(
        int $id,
        string $title,
        int $priceHT,
        Brand $brand
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->priceHT = $priceHT;
        $this->brand = $brand;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriceHT(): int
    {
        return $this->priceHT;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

}
