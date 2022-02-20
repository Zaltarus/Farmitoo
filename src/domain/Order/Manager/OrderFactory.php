<?php

namespace App\domain\Order\Manager;

use App\domain\Order\Entity\Order;
use App\domain\Order\Entity\OrderItem;
use App\domain\Product\Entity\Product;
use App\domain\User\Repository\UserRepository;

class OrderFactory
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function create(): Order
    {
        /*
         * @OnlyForTest
         * Pour le test on va considérer que l'utilisateur est connecté
        */
        $user = $this->userRepository->find(1);

        return new Order(1, $user);
    }

    public function addProduct(Order $order, Product $product, int $quantity): Order
    {
        if (!$this->checkStock($product)) {
            // A catcher dans le JS
            throw new \LogicException('Not enough stock');
        }

        /** @var OrderItem $myItem */
        foreach ($order->getItems() as &$myItem) {
            if ($myItem->getProduct()->getId() === $product->getId()) {
                $myItem->setQuantity($myItem->getQuantity() + $quantity);
                return $order;
            }
        }

        $item = new OrderItem($product, $quantity);
        $order->addItem($item);

        return $order;
    }

    private function checkStock(Product $product): bool
    {
        // @TODO checkStock
        // Pour le test stock infinie
        return true;
    }
}
