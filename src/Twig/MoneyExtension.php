<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MoneyExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getIntMoney', [$this, 'getIntMoney']),
            new TwigFunction('getCentMoney', [$this, 'getCentMoney']),
        ];
    }

    public function getIntMoney($value)
    {
        return ceil($value/100);
    }

    public function getCentMoney($value)
    {
        return substr($value, -2);
    }
}