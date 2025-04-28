<?php

        namespace App\Repository;

        use App\Entity\Product;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Doctrine\ORM\EntityManager;
        use Psr\Cache\InvalidArgumentException;
        use Doctrine\Persistence\ManagerRegistry;
        use Symfony\Contracts\Cache\CacheInterface;
        use Symfony\Contracts\Cache\ItemInterface;

        /**
         * @extends ServiceEntityRepository<Product>
         */
        class ProductsRepository extends ServiceEntityRepository
        {

            public function __construct(
                ManagerRegistry                   $registry,
                private EntityManager             $em,
                private readonly CacheInterface   $cache,
                private readonly BrandsRepository $brandsRepository,
                private readonly ImagesRepository $imagesRepository
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

            public function getAttributesByProductId(?int $productId = null): array
            {
                if ($productId === null) {
                    $product = $this->findOneBy([]);
                } else {
                    $product = $this->find($productId);
                }

                return $product ? $product->toArray() : [];
            }

            public function attributesToProperties(array $props): array
            {
                $discount = $this->getProductDiscountById($props['id']);
                $props['brand'] = $this->brandsRepository->getBrandNameById($props['brand']);
                $props['discountRate'] = $discount;
                $props['discount'] = $this->computeDiscount($props['price'], $discount);

                $props['featuresCaption'] = 'Information complémentaires';
                $props['features'] = $this->grabMoreInfo($props['more_infos']);

                $images = $this->imagesRepository->getImagesByProductId($props['id']);
                $props['images'] = $images;

                return $props;
            }

            public function grabMoreInfo(?string $phrase): array
            {
                return $phrase ? explode(';', $phrase) : [];
            }

            public function getProductDiscountById(int $productId): int
            {
                $today = new \DateTime();
                $qb = $this->em->createQueryBuilder();

                $qb->select('c.discount')
                    ->from('App\Entity\Campaign', 'c')
                    ->join('c.products', 'p')
                    ->where('p.id = :productId')
                    ->andWhere(':today BETWEEN c.start AND c.end')
                    ->setParameter('productId', $productId)
                    ->setParameter('today', $today);

                $result = $qb->getQuery()->getOneOrNullResult();

                return $result['discount'] ?? 0;
            }

            public function computeDiscount(float|string $price, int $percent): float
            {
                $price = is_string($price) ? floatval($price) : $price;
                $discountedPrice = $price - ($price * $percent / 100);

                return round($discountedPrice, 2);
            }

            /**
             * @throws InvalidArgumentException
             */
            public function deletePropertiesFromCacheById(int $productId): void
            {
                $this->cache->delete("product$productId");
            }

            public function getPropertiesFromCacheById(int $id): ?array
            {
                return $this->cache->get("product$id", function () {
                    return null;
                });
            }

            public function putPropertiesInCacheById(int $id, array $properties): void
            {
                $this->cache->get("product$id", function (ItemInterface $item) use ($properties) {
                    $item->set($properties);
                    $item->expiresAfter(3600); // Cache expiration: 1 heure
                });
            }
        }
