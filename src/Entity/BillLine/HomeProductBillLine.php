<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\ProductCategoryInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class HomeProductBillLine extends BillLineProduct implements ProductCategoryInterface
{
    private string $relation = HomeProduct::class;

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }
}
