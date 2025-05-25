<?php

namespace App\Entity\Image;

use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use App\Entity\ProductInterface;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class ClothProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ClothProduct $productClass;

    public function getProductClass(): ?ClothProduct
    {
        return $this->productClass;
    }

    public function setProductClass(ClothProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }
}
