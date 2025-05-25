<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Image\ClothProductImage>
 */
class ClothProductImageRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Image\ClothProductImage::class);
    }

    /**
     * Get the list of images associated with a given product.
     *
     * @param Uuid $productId The ID of the product
     *
     * @return Image[] Returns an array of Image objects
     */
    public function findByProductId(Uuid $productId): array
    {
        $qb = $this->createQueryBuilder('pi')
            ->join(Image::class, 'i', 'WITH', 'pi.image = i.id')
            ->andWhere('pi.product = :productId')
            ->setParameter('productId', $productId)
            ->select('i');

        return $qb->getQuery()->getResult();
    }
}
