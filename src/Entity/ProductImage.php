<?php

namespace App\Entity;

use App\Entity\Base\IdentifierTrait;
use App\Repository\ProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
class ProductImage
{
    use IdentifierTrait;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productImages')]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Image::class, inversedBy: 'productImages')]
    private ?Image $image = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

}
