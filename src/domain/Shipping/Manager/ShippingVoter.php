<?php

namespace App\domain\Shipping\Manager;


use App\domain\Brand\Repository\BrandRepository;
use App\domain\Order\Entity\Order;
use App\domain\Order\Entity\OrderItem;
use App\domain\Shipping\Entity\Shipping;
use Symfony\Component\VarDumper\VarDumper;

class ShippingVoter
{
    private BrandRepository $brandRepository;

    public function __construct(
        BrandRepository $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
    }

    public function getTotalShippingByOrder(Order $order): int
    {
        $shippingTotal = 0;
        $items = $order->getItems()->toArray();

        $itemsByBrand = [];
        // On va ordonner les items par brand
        /** @var OrderItem $item */
        foreach ($items as $item) {
            $brand = $item->getProduct()->getBrand();
            $itemsByBrand[$brand->getId()][] = $item;
        }

        foreach ($itemsByBrand as $brandId => $itemByBrand) {
            $brand = $this->brandRepository->find($brandId);
            $weight = $this->calculateWeight($itemByBrand);
            $nbProduct = $this->calculateNbProduct($itemByBrand);
            $shippings = $brand->getShipping();
            $find = false;
            /** @var Shipping $shipping */
            foreach ($shippings->toArray() as $shipping) {
                if ($this->isValid($shipping, $weight, $nbProduct)) {
                    $shippingTotal += $shipping->getPrice();
                    $find = true;
                    break;
                }
            }
            if (!$find) {
                throw new \LogicException('Shipping amount not found for ' . $brand->getName());
            }
        }

        return $shippingTotal;
    }

    /**
     * @param OrderItem[] $orderItems
     * @return int
     */
    private function calculateWeight(array $orderItems): int
    {
        // ToDo récupérer le poids de chaque produit (quand il y en aura un ;))
        return 0;
    }

    /**
     * @param OrderItem[] $orderItems
     * @return int
     */
    private function calculateNbProduct(array $orderItems): int
    {
        $quantity = 0;
        foreach ($orderItems as $item) {
            $quantity += $item->getQuantity();
        }
        return $quantity;
    }

    private function isValid(Shipping $shipping, int $weight, int $nbProduct): bool
    {
        if ($shipping->getWeightMin() > $weight) {
            return false;
        }

        if (null !== $shipping->getWeightMax() && $shipping->getWeightMax() < $weight) {
            return false;
        }

        if ($shipping->getNbArticleMin() > $nbProduct) {
            return false;
        }

        if (null !== $shipping->getNbArticleMax() && $shipping->getNbArticleMax() < $nbProduct) {
            return false;
        }

        // @ToDo vérification en fonction du pays (adresse de l'utilisateur)

        return true;
    }
}
