<?php

namespace App\Entity;

class Product
{
    private int $id;

    private string $title;

    private int $price;

    private Brand $brand;

    public function __construct(
        int $id,
        string $title,
        int $price,
        Brand $brand
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

}
