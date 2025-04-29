<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class CustomCache implements CustomCacheInterface
{
    public function __construct(private CacheItemPoolInterface $pool) {}

    /**
     * @throws InvalidArgumentException
     */
    public function set(string $key, mixed $value, int $ttl = 3600): void
    {
        $item = $this->pool->getItem($key);
        $item->set($value)->expiresAfter($ttl);
        $this->pool->save($item);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): mixed
    {
        $item = $this->pool->getItem($key);
        return $item->isHit() ? $item->get() : null;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function delete(string $key): void
    {
        $this->pool->deleteItem($key);
    }
}
