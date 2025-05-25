<?php

namespace App\Entity\Image;

use App\Entity\Product\HomeProduct;
use App\Entity\ProductImage;
use App\Entity\ProductInterface;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class HomeProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: HomeProduct::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?HomeProduct $productClass;

    public function getProductClass(): ?HomeProduct
    {
        return $this->productClass;
    }

    public function setProductClass(HomeProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }
}
