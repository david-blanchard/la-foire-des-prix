<?php

namespace App\Utils;

trait ObjectUtilsTrait
{
    public static function toObject(array $data): object
    {
        $result = null;

        $json = json_encode($data);
        $result = json_decode($json);

        return $result;
    }

    public static function toArray(object $data): array
    {
        $json = json_encode($data);
        $result = json_decode($json, JSON_OBJECT_AS_ARRAY);

        return $result;
    }
}
