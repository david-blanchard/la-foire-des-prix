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
    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ClothProduct $productClass;

    public function getProductClass(): ?ClothProduct
    {
        return $this->productClass;
    }

    public function setProductClass(?ClothProduct $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
