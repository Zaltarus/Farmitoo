<?php

namespace App\tests\Unit\Entity;

use App\domain\Order\Entity\OrderItem;
use App\domain\Order\Manager\OrderFactory;
use App\domain\Product\Entity\Product;
use App\domain\Promotion\Entity\Promotion;
use App\domain\Promotion\Manager\PromotionResolver;
use App\domain\Promotion\Repository\PromotionRepository;
use App\domain\User\Entity\User;
use App\domain\User\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testApplyPromotion()
    {
        $promotion = new Promotion(100, 10, null, null, false, true);

        $user = $this->createMock(User::class);
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('find')->willReturn($user);

        $orderFactory = new OrderFactory($userRepository);
        $order = $orderFactory->create();

        $promotionRepository = $this->createMock(PromotionRepository::class);
        $promotionRepository->method('findActive')->willReturn([$promotion]);

        $promotionResolver = new PromotionResolver($promotionRepository);

        $order = $promotionResolver->applyPromotionToOrder($order);

        $this->assertEquals($order->getPromotion(), null);

        $order->addItem($this->createOrderItem());
        $order = $promotionResolver->applyPromotionToOrder($order);

        $this->assertEquals($order->getPromotion(), $promotion);
    }
    public function testApplyBetterPromotion()
    {
        $promotion = new Promotion(100, 10, null, null, false, true);
        $promotion2 = new Promotion(100, 20, null, null, false, true);

        $user = $this->createMock(User::class);
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('find')->willReturn($user);

        $orderFactory = new OrderFactory($userRepository);
        $order = $orderFactory->create();

        $promotionRepository = $this->createMock(PromotionRepository::class);
        $promotionRepository->method('findActive')->willReturn([$promotion, $promotion2]);

        $promotionResolver = new PromotionResolver($promotionRepository);

        $order->addItem($this->createOrderItem());
        $order = $promotionResolver->applyPromotionToOrder($order);

        $this->assertEquals($order->getPromotion(), $promotion2);
    }

    private function createOrderItem(): OrderItem
    {
        $product = $this->createMock(Product::class);
        $product->method('getPriceHT')->willReturn(1000);

        $item = $this->createMock(OrderItem::class);
        $item->method('getProduct')->willReturn($product);


        return $item;
    }
}
