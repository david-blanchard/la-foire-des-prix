<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductImage>
 */
class ProductImageRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, ProductImage::class);
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
        $qb = $this->createQueryBuilder('pi')
            ->join(Image::class, 'i', 'WITH', 'pi.image = i.id')
            ->andWhere('pi.product = :productId')
            ->setParameter('productId', $productId)
            ->select('i');

        return $qb->getQuery()->getResult();
    }
}
