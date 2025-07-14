<?php

namespace App\Entity\Image;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Product\FoodProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
#[ORM\Table(name: 'food_product_image')]
class FoodProductImage extends ProductImage
{
    public readonly ?string $image_type;

    public function __construct()
    {
        $this->image_type = FoodProduct::class;
    }

    public function getProduct(): FoodProduct|\App\Entity\Product|null
    {
        return $this->product;
    }

    public function setProduct(FoodProduct|\App\Entity\Product|null $product): static
    {
        $this->product = $product;

        return $this;
    }
}
