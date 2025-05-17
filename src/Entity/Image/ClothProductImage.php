<?php

namespace App\Entity\Image;

use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class ClothProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'images')]
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
}
