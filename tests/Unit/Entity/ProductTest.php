<?php


namespace App\Tests\Unit\Entity;


use App\domain\Brand\Entity\Brand;
use App\domain\Product\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetTitle()
    {
        $brand = $this->createMock(Brand::class);

        $product = new Product('1', 'Cuve à gasoil', 100, $brand);

        $this->assertSame('Cuve à gasoil', $product->getTitle());
    }
}
