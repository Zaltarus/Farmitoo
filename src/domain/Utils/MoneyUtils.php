<?php

namespace App\domain\Brand\Entity;

class MoneyUtils
{
    public static function applyDiscount(int $amount, int $percentage, int $multiple = 100): int
    {
        return $amount * (1 - $percentage/$multiple);
    }

    public static function calculateDiscount(int $amount, int $percentage, int $multiple = 100): int
    {
        return $amount - self::applyDiscount($amount, $percentage, $multiple);
    }

    public static function applyTax(int $amount, int $percentage, int $multiple = 100): int
    {
        return $amount * (1 + ($percentage/$multiple));
    }
}
