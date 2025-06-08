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
    #[ORM\ManyToOne(targetEntity: FoodProduct::class, inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?FoodProduct $productClass;

    public function getProductClass(): ?FoodProduct
    {
        return $this->productClass;
    }

    public function setProductClass(?FoodProduct $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }
}
