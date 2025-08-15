<?php

namespace App\Service\Traits;

trait ObjectUtils
{
    /**
     * @param array<int|string, mixed> $data
     */
    public static function toObject(array $data): object
    {
        $json = (string) json_encode($data);

        return json_decode($json);
    }

    /**
     * @return array<int|string, mixed>
     */
    public static function toArray(object $data): array
    {
        $json = (string) json_encode($data);

        return json_decode($json, true);
    }
}
