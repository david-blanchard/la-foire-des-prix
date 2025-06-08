<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\FoodProduct;
use App\Entity\ProductCategoryInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class FoodProductBillLine extends BillLineProduct implements ProductCategoryInterface
{
    private string $relation = FoodProduct::class;

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }
}
