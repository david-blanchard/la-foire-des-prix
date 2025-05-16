<?php

namespace App\Repository;

use App\Entity\Product\HomeProduct;
use App\Service\CustomCacheInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeProduct>
 */
class HomeProductRepository extends ServiceEntityRepository
{
    use ProductRepositoryTrait;

    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $em,
        private readonly CustomCacheInterface $cache,
    ) {
        parent::__construct($registry, HomeProduct::class);
    }

    /**
     * Retrieve the values of a given product.
     *
     * @param int|null $productId The product ID
     *
     * @return HomeProduct|null The product entity or null if not found
     */
    public function findById(?int $productId = null): ?HomeProduct
    {
        if (null === $productId) {
            $product = $this->findAll()[0] ?? null;
        } else {
            $product = $this->find($productId);
        }

        return $product;
    }

    /**
     * Retrieve the product page properties from the database by slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return HomeProduct[] $properties Values to be set in product page view
     */
    public function findBySlug(string $slug): array
    {
        return $this->em->createQueryBuilder()
            ->from(HomeProduct::class, 'p')
            ->Where('p.slug LIKE :slugLike')
            ->setParameter('slugLike', '%'.$slug.'%')
            ->select('p')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve the product page properties from the database by slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return HomeProduct|null $properties Values to be set in product page view
     */
    public function findOneBySlug(string $slug): ?HomeProduct
    {
        $array = $this->findBySlug($slug);

        return $array[0] ?? null;
    }

    /**
     * Delete the product page properties from the cache by ID.
     */
    public function deletePropertiesFromCacheById(int $productId): void
    {
        $this->cache->delete("product$productId");
    }

    public function deletePropertiesFromCache(HomeProduct $product): void
    {
        self::deletePropertiesFromCacheById($product->getId());
    }

    /**
     * Retrieve the product page properties from the cache by ID.
     *
     * @param int $productId The product ID
     *
     * @return array<mixed>|null $properties Values to be set in product page view
     */
    public function getPropertiesFromCacheById(int $productId): ?array
    {
        return $this->cache->get("product$productId");
    }

    /**
     * Store the product page properties in cache by ID.
     *
     * @param int          $productId  The product ID
     * @param array<mixed> $properties Values to be set in product page view
     */
    public function putPropertiesInCacheById(int $productId, array $properties): void
    {
        $this->cache->set("product$productId", $properties); // Cache expiration: 1 heure
    }

    /**
     * Retrieve the product page properties from the cache by slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return array<mixed>|null $properties Values to be set in product page view
     */
    public function getPropertiesFromCacheBySlug(string $slug): ?array
    {
        $result = null;

        $productId = $this->cache->get("product$slug") ?? null;
        if (null !== $productId) {
            $result = $this->getPropertiesFromCacheById($productId);
        }

        return $result;
    }

    /**
     * Store the product page properties in cache by slug.
     *
     * @param string       $slug       Free form of the product name
     * @param array<mixed> $properties Values to be set in product page view
     */
    public function putPropertiesInCacheBySlug(string $slug, array $properties): void
    {
        if (!$this->cache->get("product$slug")) {
            $id = $properties['id'];
            $this->cache->set("product$slug", $id);
            $this->putPropertiesInCacheById($id, $properties);
        }
    }
}
