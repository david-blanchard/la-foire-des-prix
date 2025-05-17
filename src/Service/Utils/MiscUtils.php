<?php

namespace App\Service\Utils;

final class MiscUtils
{
    public static function formatPrice(float|int $price): string
    {
        $result = str_replace('.', ',', ''.round($price, 2));
        if ('0' === $result) {
            $result = '0,00';
        }

        return $result;
    }
}
