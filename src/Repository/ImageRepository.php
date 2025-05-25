<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

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

    public function findAll(): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.alt', 'ASC')
            ->getQuery()
            ->getResult();
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
        $qb = $this->createQueryBuilder('i')
            ->join(ProductImage::class, 'pi', 'WITH', 'pi.image = i.id')
            ->join(ClothProduct::class, 'p', 'WITH', 'pi.product = p.id')
            ->andWhere('pi.product = :productId')
            ->setParameter('productId', $productId)
            ->orderBy('i.alt', 'ASC')
            ->select('i');

        return $qb->getQuery()->getResult();
    }
}
