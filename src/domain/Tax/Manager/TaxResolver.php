<?php

namespace App\domain\Tax\Manager;

use App\domain\Brand\Entity\MoneyUtils;
use App\domain\Product\Entity\Product;
use Symfony\Component\VarDumper\VarDumper;

class TaxResolver
{
    private const TAX_SHIPPING = 20;

    public function getPriceTTCByProduct(Product $product): int
    {
        $tax = $product->getBrand()->getTax();
        $priceHT = $product->getPriceHT();

        return MoneyUtils::applyTax($priceHT, $tax->getRate(), 10000);
    }

    public function calculatePriceTTC(int $price): int
    {
        return MoneyUtils::applyTax($price, self::TAX_SHIPPING, 10000);
    }

}
