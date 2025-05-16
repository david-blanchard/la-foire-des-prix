<?php

namespace App\Repository;

use App\Entity\CampaignProduct;

trait ProductRepositoryTrait
{
    /**
     * Retrieve the discount of a product by its ID.
     *
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
}
