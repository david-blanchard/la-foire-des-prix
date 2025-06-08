<?php

namespace App\Entity\Image;

use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class ClothProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ClothProduct $productClass;


    #[ORM\ManyToOne(targetEntity: ClothProduct::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClothProduct $product;

    public function getProductClass(): ?ClothProduct
    {
        return $this->productClass;
    }

    public function setProductClass(ClothProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }

    public function getProduct(): ?ClothProduct
    {
        return $this->product;
    }

    public function setProduct(ClothProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }

}
