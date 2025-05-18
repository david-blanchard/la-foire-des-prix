<?php

namespace App\Repository;

use App\Entity\Product\FoodProduct;
use App\Service\CustomCacheInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoodProduct>
 */
class FoodProductRepository extends ServiceEntityRepository
{
    use ProductRepositoryTrait;

    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $em,
        private readonly CustomCacheInterface $cache,
    ) {
        parent::__construct($registry, FoodProduct::class);
    }

    /**
     * Retrieve the values of a given product.
     *
     * @param int|null $productId Product ID
     *
     * @return FoodProduct|null $product Product entity
     */
    public function findById(?int $productId = null): ?FoodProduct
    {
        if (null === $productId) {
            $product = $this->findAll()[0] ?? null;
        } else {
            $product = $this->find($productId);
        }

        return $product;
    }

    /**
     * Retrieve the values of a given product by its slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return FoodProduct[] $products Array of products
     */
    public function findBySlug(string $slug): array
    {
        return $this->em->createQueryBuilder()
            ->from(FoodProduct::class, 'p')
            ->Where('p.slug LIKE :slugLike')
            ->setParameter('slugLike', '%' . $slug . '%')
            ->select('p')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve the values of a given product by its slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return FoodProduct|null $product Product entity
     */
    public function findOneBySlug(string $slug): ?FoodProduct
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

    public function deletePropertiesFromCache(FoodProduct $product): void
    {
        self::deletePropertiesFromCacheById((int) $product->getId());
    }

    /**
     * Retrieve the product page properties from the cache by ID.
     *
     * @param int $productId Product ID
     *
     * @return array<mixed>|null $properties Values to be set in the product page view
     */
    public function getPropertiesFromCacheById(int $productId): ?array
    {
        return $this->cache->get("product$productId");
    }

    /**
     * Store the product page properties in cache by ID.
     *
     * @param int          $productId  Product ID
     * @param array<mixed> $properties Values to be set in the product page view
     */
    public function putPropertiesInCacheById(int $productId, array $properties): void
    {
        $this->cache->set("product$productId", $properties);
    }

    /**
     * Retrieve the product page properties from the cache by slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return array<mixed>|null $properties Values to be set in the product page view
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
     * @param array<mixed> $properties Values to be set in the product page view
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
