<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\FoodProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class FoodProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    private FoodProduct $product;

    #[ORM\ManyToOne(targetEntity: FoodProduct::class, inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public function getProduct(): FoodProduct
    {
        return $this->product;
    }

    public function setProduct(FoodProduct $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }
}
