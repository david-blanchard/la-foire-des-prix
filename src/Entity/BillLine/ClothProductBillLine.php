<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductCategoryInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class ClothProductBillLine extends BillLineProduct implements ProductCategoryInterface
{
    private string $relation = ClothProduct::class;

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
