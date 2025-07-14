<?php

namespace App\Entity\Image;

use App\Entity\Product\HomeProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
#[ORM\Table(name: 'home_product_image')]
class HomeProductImage extends ProductImage
{
    public readonly string $image_type;

    public function __construct()
    {
        $this->image_type = HomeProduct::class;
    }

    public function getProduct(): HomeProduct|\App\Entity\Product|null
    {
        return $this->product;
    }

    public function setProduct(HomeProduct|\App\Entity\Product|null $product): static
    {
        $this->product = $product;

        return $this;
    }
}
