<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\HomeProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class HomeProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    private HomeProduct $product;

    #[ORM\ManyToOne(targetEntity: HomeProduct::class, inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public function getProduct(): HomeProduct
    {
        return $this->product;
    }

    public function setProduct(HomeProduct $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }
}
