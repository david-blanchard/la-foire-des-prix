<?php

namespace App\Repository;

use App\Entity\Image;
use App\Repositories\ImagesRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 */
class ImagesRepository extends ServiceEntityRepository implements ImagesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
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
            ->join('i.productImages', 'pi')
            ->where('pi.product = :productId')
            ->setParameter('productId', $productId);

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
