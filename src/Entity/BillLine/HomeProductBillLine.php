<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\ProductInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class HomeProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    #[ORM\ManyToOne(targetEntity: HomeProduct::class, inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?HomeProduct $productClass;

    public function getProductClass(): ?HomeProduct
    {
        return $this->productClass;
    }

    public function setProductClass(?HomeProduct $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }
}
