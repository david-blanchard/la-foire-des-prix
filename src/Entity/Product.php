<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['product.read'],
    ],
    denormalizationContext: [
        'groups' => ['product.write'],
    ],
    mercure: true
)]
#[ORM\Entity()]
#[ORM\Table(name: 'products')]
class Product implements ProductInterface
{
    use Identifier;
    use Classifier;
    use TimestampableEntity;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product.read', 'product.write'])]
    protected ?string $name = null;

    #[ORM\Column(length: 1024, nullable: true)]
    #[Groups(['product.read', 'product.write'])]
    protected ?string $description = null;


    #[ORM\Column(length: 1024, nullable: true)]
    #[Groups(['product.read', 'product.write'])]
    protected ?string $moreInfo = null;

    #[ORM\Column(type: 'float')]
    #[Groups(['product.read', 'product.write'])]
    protected float $price = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product.read', 'product.write'])]
    protected ?Brand $brand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreInfo(): ?string
    {
        return $this->moreInfo;
    }

    public function setMoreInfo(?string $moreInfo): static
    {
        $this->moreInfo = $moreInfo;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategoryName(): string
    {
        return '';
    }
}
