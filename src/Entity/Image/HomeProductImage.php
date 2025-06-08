<?php

namespace App\Entity\Image;

use App\Entity\Product\HomeProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class HomeProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: HomeProduct::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?HomeProduct $productClass;

    #[ORM\ManyToOne(targetEntity: HomeProduct::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?HomeProduct $product;

    public function getProductClass(): ?HomeProduct
    {
        return $this->productClass;
    }

    public function setProductClass(HomeProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }

    public function getProduct(): ?HomeProduct
    {
        return $this->product;
    }

    public function setProduct(HomeProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
