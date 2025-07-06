<?php

namespace App\Entity\Image;

use App\Entity\Product\HomeProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class HomeProductImage extends ProductImage
{
    public readonly string $relation;

    public function __construct()
    {
        $this->relation = HomeProduct::class;
    }

    public function getProduct(): HomeProduct|null|\App\Entity\Product
    {
        return $this->product;
    }

    public function setProduct(HomeProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
