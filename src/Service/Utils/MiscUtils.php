<?php

namespace App\Service\Utils;

use App\Service\Traits\ObjectUtils;

final class MiscUtils
{
    use ObjectUtils;

    public static function formatPrice(float|int $price): string
    {

        $result = str_replace(".", ",", "" . round($price, 2) . "");
        if($result === "0") {
            $result = "0,00";
        }

        return $result;
    }
}
