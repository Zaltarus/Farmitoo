<?php

namespace App\domain\Tax\Entity;

class Tax
{
    private int $id;

    private int $rate;

    public function __construct(int $id, int $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

}
