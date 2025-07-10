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
    public readonly ?string $relation;

    public function __construct()
    {
        $this->relation = ClothProduct::class;
    }

    public function getProduct(): ClothProduct|null|\App\Entity\Product
    {
        return $this->product;
    }

    public function setProduct(ClothProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }

}
