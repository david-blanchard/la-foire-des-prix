<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Identifier;
use App\Repository\ProductImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['product-image.read', 'product.read', 'image.read'],
    ],
    denormalizationContext: [
        'groups' => ['product-image.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
#[ORM\Table(name: 'product_images')]
class ProductImage
{
    use Identifier;
    use TimestampableEntity;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups([
        'product-image.read',
        'product-image.write',
        'image.read',
    ])]
    protected ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups([
        'product-image.read',
        'product-image.write',
        'product.read',
    ])]
    protected ?Product $product = null;

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
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
