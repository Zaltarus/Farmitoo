<?php

namespace App\domain\Promotion\Entity;

class Promotion
{
    private int $minAmount;

    private int $reduction;

    private ?\DateTimeImmutable $dateStart;

    private ?\DateTimeImmutable $dateEnd;

    private bool $freeDelivery;

    private bool $active;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $minAmount,
        int $reduction,
        ?\DateTimeImmutable $dateStart,
        ?\DateTimeImmutable $dateEnd,
        bool $freeDelivery,
        bool $active
    ) {
        $this->minAmount = $minAmount;
        $this->reduction = $reduction;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->freeDelivery = $freeDelivery;
        $this->active = $active;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getMinAmount(): int
    {
        return $this->minAmount;
    }

    public function getReduction(): int
    {
        return $this->reduction;
    }

    public function getDateStart(): ?\DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function getDateEnd(): ?\DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function isFreeDelivery(): bool
    {
        return $this->freeDelivery;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
