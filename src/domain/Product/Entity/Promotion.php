<?php


namespace App\domain\Product\Entity;


class Promotion
{
    private int $minAmount;

    private int $reduction;

    private ?\DateTimeImmutable $dateDate;

    private ?\DateTimeImmutable $dateEnd;

    private bool $freeDelivery;

    private bool $active;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $minAmount,
        int $reduction,
        ?\DateTimeImmutable $dateDate,
        ?\DateTimeImmutable $dateEnd,
        bool $freeDelivery,
        bool $active
    ) {
        $this->minAmount = $minAmount;
        $this->reduction = $reduction;
        $this->dateDate = $dateDate;
        $this->dateEnd = $dateEnd;
        $this->freeDelivery = $freeDelivery;
        $this->active = $active;
        $this->createdAt = new \DateTimeImmutable();
    }
}
