<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Brand>
 */
class BrandRepository extends ServiceEntityRepository
{
    private CacheInterface $cache;

    public function __construct(ManagerRegistry $registry, CacheInterface $cache)
    {
        parent::__construct($registry, Brand::class);
        $this->cache = $cache;
    }

    public function findNameById(Uuid $brandId): ?string
    {
        $brand = $this->find($brandId);

        return $brand ? $brand->getName() : null;
    }

    /**
     * @return Brand[]
     */
    public function findAllFromCache(): array
    {
        return $this->cache->get('brands', function (ItemInterface $item) {
            $item->expiresAfter(3600); // Cache expiration: 1 heure

            return $this->findAll();
        });
    }
}
