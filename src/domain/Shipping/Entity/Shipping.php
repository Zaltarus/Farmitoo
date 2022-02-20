<?php

namespace App\domain\Shipping\Entity;

use App\domain\Country\Entity\Country;

class Shipping
{
    private int $id;

    private Country $country;

    private int $weightMin;

    private ?int $weightMax;

    private int $nbArticleMin;

    private ?int $nbArticleMax;

    private int $price;

    public function __construct(
        int $id,
        Country $country,
        int $weightMin,
        ?int $weightMax,
        int $nbArticleMin,
        ?int $nbArticleMax,
        int $price
    ) {
        $this->id = $id;
        $this->country = $country;
        $this->weightMin = $weightMin;
        $this->weightMax = $weightMax;
        $this->nbArticleMin = $nbArticleMin;
        $this->nbArticleMax = $nbArticleMax;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getNbArticleMin(): int
    {
        return $this->nbArticleMin;
    }

    public function getNbArticleMax(): ?int
    {
        return $this->nbArticleMax;
    }

    public function getWeightMin(): int
    {
        return $this->weightMin;
    }

    public function getWeightMax(): ?int
    {
        return $this->weightMax;
    }


    public function getPrice(): int
    {
        return $this->price;
    }
}
