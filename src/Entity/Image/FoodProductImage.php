<?php

namespace App\Entity\Image;

use App\Entity\Product\FoodProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class FoodProductImage extends ProductImage
{
    private string $relation = FoodProduct::class;

    #[ORM\ManyToOne(targetEntity: FoodProduct::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodProduct $product;

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function getProduct(): ?FoodProduct
    {
        return $this->product;
    }

    public function setProduct(FoodProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
