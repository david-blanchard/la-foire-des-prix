<?php

namespace App\Repository;

use App\Entity\CampaignProduct;
use App\Entity\Product;
use App\Service\CustomCacheInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{

    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $em,
        private readonly CustomCacheInterface $cache,
        private readonly ImageRepository $imagesRepository
    ) {
        parent::__construct($registry, Product::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getById(int $id): ?Product
    {
        return $this->find($id);
    }

    /**
     * Retrieve the values of a given product
     *
     * @param integer|null $productId
     * @return array
     */
    public function getAttributesByProductId(?int $productId = null): ?Product
    {
        if ($productId === null) {
            $product = $this->findOneBy([]);
        } else {
            $product = $this->find($productId);
        }

        return $product;
    }

    /**
     * Transform ProductInfo attributes in properties usable in views
     *
     * @param array $props
     * @return array
     */
    public function attributesToProperties(Product $product): array
    {
        $discount = $this->getProductDiscountById($product->getId());
        $props = [];
        $props['name'] = $product->getName();
        $props['id'] = $product->getId();
        $props['description'] = $product->getDescription();
        $props['moreInfo'] = $product->getMoreInfo();
        $props['price'] = $product->getPrice();
        $props['brand'] = $product->getBrand()->getName();
        $props['discountRate'] = $discount;
        $props['discount'] = $this->computeDiscount($product->getPrice(), $discount);

        $props['featuresCaption'] = 'Information complémentaires';
        $props['features'] = $this->grabMoreInfo($product->getMoreInfo());

        $images = $this->imagesRepository->getImagesByProductId($product->getId());
        $props['images'] = $images;

        return $props;
    }

    /**
     * Transform a string of more info into an array
     *
     * @param string|null $phrase
     * @return array
     */
    public function grabMoreInfo(?string $phrase): array
    {
        return $phrase ? explode(';', $phrase) : [];
    }

    public function findBySlug(string $slug): array
    {
        return $this->em->createQueryBuilder()
            ->from(Product::class, 'p')
            ->Where('p.slug LIKE :slugLike')
            ->setParameter('slugLike', '%' . $slug . '%')
            ->select('p')
            ->getQuery()
            ->getResult();
    }

    public function findOneBySlug(string $slug): ?Product
    {
        $array = $this->findBySlug($slug);

        return $array[0] ?? null;
    }

    /**
     * Retrieve the discount of a product by its ID
     *
     * @param int $productId
     * @return int Discount percentage
     */
    public function getProductDiscountById(int $productId): int
    {
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
     * Compute the discounted price of a product
     *
     * @param float|string $price Original price
     * @param int $percent Discount percentage
     * @return float Discounted price
     */
    public function computeDiscount(float|string $price, int $percent): float
    {
        $price = is_string($price) ? floatval($price) : $price;
        $discountedPrice = $price - ($price * $percent / 100);

        return round($discountedPrice, 2);
    }

    /**
     * Delete the product page properties from the cache by ID
     *
     * @param int $productId
     * @return void
     */
    public function deletePropertiesFromCacheById(int $productId): void
    {
        $this->cache->delete("product$productId");
    }

    public function deletePropertiesFromCache(Product $product) : void
    {
        self::deletePropertiesFromCacheById($product->getId());
    }

    public function getPropertiesFromCacheById(int $productId): ?array
    {
        return $this->cache->get("product$productId");
    }

    public function putPropertiesInCacheById(int $productId, array $properties): void
    {
        $this->cache->get("product$productId"); // Cache expiration: 1 heure
    }


    /**
     * Retrieve the product page properties from the cache by slug
     *
     * @param string $slug Free form of the product name
     * @return array|null $properties Values to be set in product page view
     */
    public function getPropertiesFromCacheBySlug(string $slug): ?array
    {
        $result = null;

        $productId = $this->cache->get("product$slug") ?? null;
        if($productId !== null) {
            $result = $this->getPropertiesFromCacheById($productId);
        }

        return $result;
    }

    /**
     * Store the product page properties in cache by slug
     *
     * @param string $slug Free form of the product name
     * @param array $properties Values to be set in product page view
     * @return void
     */
    public function putPropertiesInCacheBySlug(string $slug, array $properties): void
    {
        if(!$this->cache->get("product$slug"))
        {
            $id = $properties['id'];
            $this->cache->set("product$slug", $id);
            $this->putPropertiesInCacheById($id, $properties);
        }
    }

}
