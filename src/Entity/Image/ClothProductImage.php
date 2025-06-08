<?php

namespace App\Entity\Image;

use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use App\Repository\ClothProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductImageRepository::class)]
class ClothProductImage extends ProductImage
{
    private ?string $relation = ClothProduct::class;

    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClothProduct $product;

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function getProduct(): ?ClothProduct
    {
        return $this->product;
    }

    public function setProduct(ClothProduct|null|\App\Entity\Product $product): static
    {
        $this->product = $product;

        return $this;
    }

}
