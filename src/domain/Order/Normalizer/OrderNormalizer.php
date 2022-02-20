<?php

namespace App\domain\Order\Normalizer;

use App\domain\Brand\Entity\MoneyUtils;
use App\domain\Order\Entity\Order;
use App\domain\Order\Entity\OrderItem;
use App\domain\Product\Entity\Product;
use App\domain\Promotion\Entity\Promotion;
use App\domain\Tax\Manager\TaxResolver;
use App\domain\User\Repository\UserRepository;
use Symfony\Component\VarDumper\VarDumper;

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
        $items = array_map(
            function (OrderItem $orderItem) use($promotion): array {
                $product = $orderItem->getProduct();
                $quantity = $orderItem->getQuantity();
                $priceHT = $product->getPriceHT();
                $priceHTDiscount = $this->calculateDiscount($product, $promotion);
                return [
                    'product' => [
                        'id' => $product->getId(),
                        'title' => $product->getTitle(),
                        'priceHT' => $priceHTDiscount*$quantity,
                        'priceTTC' => $this->taxResolver->getPriceTTCByProduct($product)*$quantity,
                        'priceCrossed' => $priceHT !== $priceHTDiscount ? $priceHT*$quantity : null,
                    ],
                    'quantity' => $quantity,
                ];
            },
            $order->getItems()->toArray()
        );

        $discount = $this->getDiscount($order, $items);
        return [
            'id' => $order->getId(),
            'items' => $items,
            'discount' => $discount,
            'total' => $this->getTotal($items, $discount),
        ];
    }

    private function getDiscount(Order $order, array $orderItemsNormalized): ?array
    {
        $promotion = $order->getPromotion();
        if (null === $promotion) {
            return null;
        }

        $total = $this->getTotal($orderItemsNormalized);
        $reduction = $promotion->getReduction();

        return [
            'totalHT' => MoneyUtils::calculateDiscount($total['totalHT'], $reduction),
            'totalTTC' => MoneyUtils::calculateDiscount($total['totalTTC'], $reduction),
        ];
    }


    /**
     * @param array<int, array{'product': array{title: string, priceHT: int, priceTTC: int, priceCrossed: int}, quantity: int}> $orderItemsNormalized
     * @param array{totalHT: int, totalTTC: int}
     * @return array{totalHT: int, totalTTC: int}
     */
    private function getTotal(array $orderItemsNormalized, ?array $discountNormalized = null): array
    {
        $totalHT = 0;
        $totalTTC = 0;
        foreach ($orderItemsNormalized as $item) {
            $totalHT += $item['product']['priceHT'];
            $totalTTC += $item['product']['priceTTC'];
        }

        if ($totalHT > $totalTTC) {
            // A catcher
            throw new \LogicException('Total HT is inferior to TTC');
        }

        $totalHTBeforeDiscount = $totalHT;
        $totalTTCBeforeDiscount = $totalTTC;
        if (null !== $discountNormalized) {
            $totalHT = $totalHT - $discountNormalized['totalHT'];
            $totalTTC = $totalTTC - $discountNormalized['totalTTC'];
        }

        return [
            'totalHTBeforeDiscount' => $totalHTBeforeDiscount,
            'totalHT' => $totalHT,
            'totalTTCBeforeDiscount' => $totalTTCBeforeDiscount,
            'totalTTC' => $totalTTC,
            'TVA' => $totalTTC - $totalHT,
        ];
    }


    private function calculateDiscount(Product $product, ?Promotion $promotion): ?int
    {
        if (null === $promotion) {
            return null;
        }

        return MoneyUtils::applyDiscount($product->getPriceHT(), $promotion->getReduction());
    }
}
