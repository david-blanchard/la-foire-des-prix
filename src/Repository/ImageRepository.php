<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Image::class);
    }

    /**
     * Get the list of images associated with a given product.
     *
     * @param int $productId The ID of the product
     *
     * @return Image[] Returns an array of Image objects
     */
    public function findByProductId(int $productId): array
    {
        $qb = $this->createQueryBuilder('i')
            ->join(ProductImage::class, 'pi', 'WITH', 'pi.image = i.id')
            ->join(Product::class, 'p', 'WITH', 'pi.product = p.id')
            ->andWhere('pi.product = :productId')
            ->setParameter('productId', $productId)
            ->select('i');

        return $qb->getQuery()->getResult();
    }
}
