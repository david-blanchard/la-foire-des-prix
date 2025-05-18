<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FormatPriceExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_price', $this->formatPrice(...)),
        ];
    }

    public function formatPrice(float $price): string
    {
        return number_format($price, 2, ',', ' ') . ' €';
    }
}
