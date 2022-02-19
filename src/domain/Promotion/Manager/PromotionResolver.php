<?php

namespace App\domain\Promotion\Manager;

use App\domain\Order\Entity\Order;
use App\domain\Order\Entity\OrderItem;
use App\domain\Product\Entity\Product;
use App\domain\Promotion\Repository\PromotionRepository;
use App\domain\User\Repository\UserRepository;
use Symfony\Component\VarDumper\VarDumper;

class PromotionResolver
{
    private PromotionRepository $promotionRepository;

    public function __construct(
        PromotionRepository $promotionRepository
    ) {
        $this->promotionRepository = $promotionRepository;
    }

    public function applyPromotionToOrder(Order $order): Order
    {
        $promotions = $this->promotionRepository->findActive();

        $totalAmount = $this->calculateTotalAmount($order);

        foreach ($promotions as $promotion) {
            if ($promotion->getMinAmount() < $totalAmount) {
                $orderPromotion = $order->getPromotion();
                // On prend la promotion la plus avantageuse pour le client
                if (null !== $orderPromotion && $orderPromotion->getReduction() > $promotion->getReduction()) {
                    continue;
                }
                $order->setPromotion($promotion);
            }
        }

        return $order;
    }

    private function calculateTotalAmount(Order $order): int
    {
        /** @var OrderItem[] $items */
        $items = $order->getItems()->toArray();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->getProduct()->getPriceHT();
        }

        return $total;
    }
}
