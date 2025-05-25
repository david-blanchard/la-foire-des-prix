<?php

namespace App\Entity\Image;

use App\Entity\Product\FoodProduct;
use App\Entity\ProductImage;
use App\Entity\ProductInterface;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class FoodProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: FoodProduct::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?FoodProduct $productClass;

    public function getProductClass(): ?FoodProduct
    {
        return $this->productClass;
    }

    public function setProductClass(FoodProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }
}
