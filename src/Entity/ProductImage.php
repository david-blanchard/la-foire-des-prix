<?php

namespace App\Entity;

use App\Entity\Image\ClothProductImage;
use App\Entity\Image\FoodProductImage;
use App\Entity\Image\HomeProductImage;
use App\Entity\Traits\Identifier;
use App\Repository\ProductImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
#[ORM\Table(name: 'product_images')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'product', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductImage::class,
    'food' => FoodProductImage::class,
    'home' => HomeProductImage::class,
])]
class ProductImage
{
    use Identifier;
    use TimestampableEntity;

    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $productId;

    #[ORM\ManyToOne(targetEntity: Image::class, inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Image $image;

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }
}
