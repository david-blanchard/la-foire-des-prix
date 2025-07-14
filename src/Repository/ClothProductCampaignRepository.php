<?php

namespace App\Repository;

use App\Entity\Campaign;
use App\Entity\Product\ClothProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campaign\ClothProductCampaign>
 */
class ClothProductCampaignRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Campaign\ClothProductCampaign::class);
    }

    /**
     * @return Campaign\ClothProductCampaign[]
     */
    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getById(int $id): ?Campaign\ClothProductCampaign
    {
        return $this->find($id);
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
        /*
         *         $today = new \DateTime();
         *         $qb = $this->createQueryBuilder('cp');
         *
         *         $qb->join('cp.campaign', 'c')
         *             ->join(ClothProduct::class, 'p', 'WITH', 'cp.product = p.id')
         *             ->where('cp.product = :productId')
         *             ->andWhere($qb->expr()->between(':today', 'c.startsAt', 'c.endsAt'))
         *             ->setParameter('productId', $productId)
         *             ->setParameter('today', $today)
         *             ->select('c.discount');
         *
         *         $result = $qb->getQuery()->getOneOrNullResult();
         */

        /*
         *  return $result['discount'] ?? 0;
         */

        return 0;
    }
}
