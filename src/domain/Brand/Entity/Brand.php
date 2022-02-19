<?php

namespace App\domain\Brand\Entity;

use App\domain\Tax\Entity\Tax;

class Brand
{
    private int $id;

    private string $name;

    private Tax $tax;

    public function __construct(int $id, string $name, Tax $tax)
    {
        $this->id = $id;
        $this->name = $name;
        $this->tax = $tax;
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
}
