<?php

namespace App\domain\Brand\Entity;

use App\domain\Shipping\Entity\Shipping;
use App\domain\Tax\Entity\Tax;
use Doctrine\Common\Collections\Collection;

class Brand
{
    private int $id;

    private string $name;

    private Tax $tax;

    /**
     * @var Collection<int, Shipping>
     */
    private Collection $shipping;

    public function __construct(int $id, string $name, Tax $tax, Collection $shipping)
    {
        $this->id = $id;
        $this->name = $name;
        $this->tax = $tax;
        $this->shipping = $shipping;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTax(): Tax
    {
        return $this->tax;
    }

    public function getShipping(): Collection
    {
        return $this->shipping;
    }
}
