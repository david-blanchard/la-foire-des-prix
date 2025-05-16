<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;

interface CustomCacheInterface
{
    public function __construct(CacheItemPoolInterface $pool);

    public function set(string $key, mixed $value, int $ttl = 3600): void;

    public function get(string $key): mixed;

    public function delete(string $key): void;
}
