<?php

namespace App\domain\Tax\Manager;

use App\domain\Product\Entity\Product;
use Symfony\Component\VarDumper\VarDumper;

class TaxResolver
{
    public function getPriceTTCByProduct(Product $product): int
    {
        $tax = $product->getBrand()->getTax();
        $priceHT = $product->getPriceHT();

        return $priceHT * (1 + ($tax->getRate()/10000));
    }
}
