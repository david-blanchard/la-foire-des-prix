<?php

namespace App\Entity\Image;

use App\Entity\Product\HomeProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class HomeProductImage extends ProductImage
{
    private string $relation = HomeProduct::class;

    #[ORM\ManyToOne(targetEntity: HomeProduct::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?HomeProduct $product;

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

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
