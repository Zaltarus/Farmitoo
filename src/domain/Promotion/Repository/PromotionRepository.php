<?php

namespace App\domain\Promotion\Repository;

use App\domain\Brand\Repository\BrandRepository;
use App\domain\Product\Entity\Product;
use App\domain\Promotion\Entity\Promotion;

class PromotionRepository
{
    /**
     * @return Promotion[]
     */
    public function findAll(): array
    {
        return [
            1 => new Promotion(50000, 8, null, null, false, true),
        ];
    }

    public function find(int $id): ?Promotion
    {
        $promotions = $this->findAll();

        if (isset($promotions[$id])) {
            return $promotions[$id];
        }

        return null;
    }

    /**
     * @return Promotion[]
     */
    public function findActive(): array
    {
        $promotions = $this->findAll();

        $now = new \DateTimeImmutable();
        return array_filter(
            $promotions,
            static function (Promotion $promotion) use($now): bool {
                return $promotion->isActive()
                    && ($now > $promotion->getDateStart() || null === $promotion->getDateStart())
                    && ($now < $promotion->getDateEnd() || null === $promotion->getDateEnd());
            }
        );
    }
}
