<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\ClothProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class ClothProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ClothProduct $product;

    public function getProduct(): ?ClothProduct
    {
        return $this->product;
    }

    public function setProduct(?ClothProduct $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
