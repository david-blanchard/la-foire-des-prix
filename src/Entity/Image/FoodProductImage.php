<?php

namespace App\Entity\Image;

use App\Entity\Product;
use App\Entity\Product\FoodProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class FoodProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: FoodProduct::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?FoodProduct $productClass;

    #[ORM\ManyToOne(targetEntity: ClothProduct::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodProduct $product;

    public function getProductClass(): ?FoodProduct
    {
        return $this->productClass;
    }

    public function setProductClass(FoodProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }

    public function getProduct(): ?FoodProduct
    {
        return $this->product;
    }

    public function setProduct(FoodProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
