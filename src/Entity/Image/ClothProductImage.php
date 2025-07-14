<?php

namespace App\Entity\Image;

use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
#[ORM\Table(name: 'cloth_product_image')]
class ClothProductImage extends ProductImage
{
    public readonly ?string $image_type;

    public function __construct()
    {
        $this->image_type = ClothProduct::class;
    }

    public function getProduct(): ClothProduct|\App\Entity\Product|null
    {
        return $this->product;
    }

    public function setProduct(ClothProduct|\App\Entity\Product|null $product): static
    {
        $this->product = $product;

        return $this;
    }
}
