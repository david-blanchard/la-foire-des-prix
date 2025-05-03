<?php

namespace App\Repository;

use App\Entity\CampaignProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CampaignProduct>
 */
class CampaignProductsRepository extends ServiceEntityRepository
{

    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, CampaignProduct::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getById(int $id): ?CampaignProduct
    {
        return $this->find($id);
    }

}
