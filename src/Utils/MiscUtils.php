<?php

namespace App\Utils;

final class MiscUtils
{
    use ObjectUtilsTrait;

    public static function formatPrice(float|int $price): string
    {

        $result = str_replace(".", ",", "" . round($price, 2) . "");
        if($result === "0") {
            $result = "0,00";
        }

        return $result;
    }
}
