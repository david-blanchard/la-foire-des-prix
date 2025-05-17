<?php

namespace App\Entity\Image;

use App\Entity\Product\HomeProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class HomeProductImage extends ProductImage
{
    #[ORM\ManyToOne(targetEntity: HomeProduct::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?HomeProduct $product;

    public function getProduct(): ?HomeProduct
    {
        return $this->product;
    }

    public function setProduct(?HomeProduct $product): static
    {
        $this->product = $product;

        return $this;
    }
}
