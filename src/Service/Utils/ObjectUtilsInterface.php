<?php

namespace App\Service\Utils;

interface ObjectUtilsInterface
{
    /**
     * @param array<int|string, mixed> $data
     */
    public static function toObject(array $data): object;

    /**
     * @return array<int|string, mixed>
     */
    public static function toArray(object $data): array;
}
