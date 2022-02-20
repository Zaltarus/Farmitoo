<?php

namespace App\tests\Unit\Entity;

use App\domain\Order\Entity\OrderItem;
use App\domain\Order\Manager\OrderFactory;
use App\domain\Product\Entity\Product;
use App\domain\User\Entity\User;
use App\domain\User\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    public function testAddProduct()
    {
        $product = $this->createMock(Product::class);

        $user = $this->createMock(User::class);
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('find')->willReturn($user);

        $orderFactory = new OrderFactory($userRepository);
        $order = $orderFactory->create();
        $order = $orderFactory->addProduct($order, $product, 10);

        $items = $order->getItems();
        /** @var OrderItem $item */
        $item = $items->current();

        $this->assertEquals($item->getProduct(), $product);
        $this->assertSame($item->getQuantity(), 10);
    }
}
