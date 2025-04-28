<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Brand>
 */
class BrandsRepository extends ServiceEntityRepository
{
    private CacheInterface $cache;

    public function __construct(ManagerRegistry $registry, CacheInterface $cache)
    {
        parent::__construct($registry, Brand::class);
        $this->cache = $cache;
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getById(int $id): ?Brand
    {
        return $this->find($id);
    }

    public function getBrandNameById(int $brandId): ?string
    {
        $brand = $this->find($brandId);
        return $brand ? $brand->getName() : null;
    }

    public function getAllFromCache(): array
    {
        return $this->cache->get('brands', function (ItemInterface $item) {
            $item->expiresAfter(3600); // Cache expiration: 1 heure
            return $this->findAll();
        });
    }
}
