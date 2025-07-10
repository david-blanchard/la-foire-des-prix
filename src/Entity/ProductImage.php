<?php

namespace App\Entity;

use App\Entity\Image\ClothProductImage;
use App\Entity\Image\FoodProductImage;
use App\Entity\Image\HomeProductImage;
use App\Entity\Traits\Identifier;
use App\Repository\ProductImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
#[ORM\Table(name: 'product_images')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'image_type', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductImage::class,
    'food' => FoodProductImage::class,
    'home' => HomeProductImage::class,
])]
class ProductImage
{
    use Identifier;
    use TimestampableEntity;

    #[ORM\ManyToOne(targetEntity: Image::class, inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    protected ?Image $image;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    protected ?Product $product = null;


    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

}
