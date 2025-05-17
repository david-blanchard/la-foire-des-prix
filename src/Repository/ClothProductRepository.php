<?php

namespace App\Repository;

use App\Entity\CampaignProduct;
use App\Entity\Product\ClothProduct;
use App\Service\CustomCacheInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClothProduct>
 */
class ClothProductRepository extends ServiceEntityRepository
{

    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $em,
        private readonly CustomCacheInterface $cache,
    ) {
        parent::__construct($registry, ClothProduct::class);
    }

    /**
     * Retrieve the values of a given product.
     */
    public function findById(?int $productId = null): ?ClothProduct
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
     * @return ClothProduct[] $products Array of products
     */
    public function findBySlug(string $slug): array
    {
        return $this->em->createQueryBuilder()
            ->from(ClothProduct::class, 'p')
            ->Where('p.slug LIKE :slugLike')
            ->setParameter('slugLike', '%'.$slug.'%')
            ->select('p')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve the values of a given product by its slug.
     *
     * @param string $slug Free form of the product name
     *
     * @return ClothProduct|null $product Product object
     */
    public function findOneBySlug(string $slug): ?ClothProduct
    {
        $array = $this->findBySlug($slug);

        return $array[0] ?? null;
    }

    /**
     * Retrieve the discount of a product by its ID.
     *
     * @return int Discount percentage
     */
    public function getProductDiscountById(?int $productId): int
    {

        if (null === $productId) {
            return 0;
        }

        $today = new \DateTime();
        $qb = $this->em->createQueryBuilder();

        $qb->select('c.discount')
            ->from(CampaignProduct::class, 'cp')
            ->join('cp.campaign', 'c')
            ->where('cp.product = :productId')
            ->join('cp.product', 'p')
            ->where('p.id = :productId')
            ->andWhere(':today BETWEEN c.startsAt AND c.endsAt')
            ->setParameter('productId', $productId)
            ->setParameter('today', $today);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result['discount'] ?? 0;
    }

    /**
     * Delete the product page properties from the cache by ID.
     */
    public function deletePropertiesFromCacheById(int $productId): void
    {
        $this->cache->delete("product$productId");
    }

    public function deletePropertiesFromCache(ClothProduct $product): void
    {
        self::deletePropertiesFromCacheById((int) $product->getId());
    }

    /**
     * @return array<mixed>|null
     */
    public function getPropertiesFromCacheById(int $productId): ?array
    {
        return $this->cache->get("product$productId");
    }

    /**
     * Store the product page properties in cache by ID.
     *
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
