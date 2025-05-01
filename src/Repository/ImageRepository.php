<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $em,
    )
    {
        parent::__construct($registry, Image::class);
    }

    /**
     * Get the list of images associated with a given product
     *
     * @param int $productId
     * @return array
     */
    public function getImagesByProductId(int $productId): array
    {
        $qb = $this->createQueryBuilder('i')
            ->join(ProductImage::class, 'pi')
            ->where('pi.product = :productId')
            ->andWhere('pi.image = i.id')
            ->setParameter('productId', $productId)
            ->select('i');

        return $qb->getQuery()->getResult();
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getById($id): ?Image
    {
        return $this->find($id);
    }
}
