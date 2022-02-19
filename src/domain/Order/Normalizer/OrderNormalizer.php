<?php

namespace App\domain\Order\Normalizer;

use App\domain\Order\Entity\Order;
use App\domain\Order\Entity\OrderItem;
use App\domain\Product\Entity\Product;
use App\domain\Promotion\Entity\Promotion;
use App\domain\Tax\Manager\TaxResolver;
use App\domain\User\Repository\UserRepository;

class OrderNormalizer
{
    private TaxResolver $taxResolver;

    public function __construct(TaxResolver $taxResolver)
    {
        $this->taxResolver = $taxResolver;
    }

    public function normalize(Order $order): array
    {
        $promotion = $order->getPromotion();
        return [
            'id' => $order->getId(),
            'items' => array_map(
                function (OrderItem $orderItem) use($promotion): array {
                    $product = $orderItem->getProduct();
                    return [
                        'product' => [
                            'title' => $product->getTitle(),
                            'priceHT' => $product->getPriceHT(),
                            'priceTTC' => $this->taxResolver->getPriceTTCByProduct($product),
                            'priceCrossed' => $this->calculatePriceCrossed($product, $promotion),
                        ],
                        'quantity' => $orderItem->getQuantity(),
                    ];
                },
                $order->getItems()->toArray()
            ),
            'promotion' => []
        ];
    }

    private function calculatePriceCrossed(Product $product, ?Promotion $promotion): ?int
    {
        if (null === $promotion) {
            return null;
        }

        return $product->getPriceHT() * (1 - ($promotion->getReduction()/100));
    }
}
