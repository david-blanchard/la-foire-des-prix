<?php

namespace App\Entity;

use App\Entity\Product\ClothProduct;
use App\Entity\Product\FoodProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
#[ORM\Table(name: 'products')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'relation', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProduct::class,
    'food' => FoodProduct::class,
    'home' => HomeProduct::class,
])]
abstract class Product
{
    use Identifier;
    use Classifier;
    use TimestampableEntity;

    #[ORM\Column(length: 1024)]
    protected string $description;

    #[ORM\Column(length: 1024, nullable: true)]
    protected ?string $moreInfo = null;

    #[ORM\Column(type: 'float')]
    protected float $price;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Brand $brand;

    /**
     * @var Collection<int, CampaignProduct> $campaignProducts
     */
    #[ORM\ManyToMany(targetEntity: CampaignProduct::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    protected Collection $campaignProducts;

    public function __construct()
    {
        $this->campaignProducts = new ArrayCollection();
//        $this->productImages = new ArrayCollection();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreInfo(): ?string
    {
        return $this->moreInfo;
    }

    public function setMoreInfo(?string $moreInfo): self
    {
        $this->moreInfo = $moreInfo;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, CampaignProduct>
     */
    public function getCampaignProducts(): Collection
    {
        return $this->campaignProducts;
    }

//    abstract public function addCampaignProduct(CampaignProduct $campaignProduct): self;

    public function removeCampaignProduct(CampaignProduct $campaignProduct): self
    {
        if ($this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts->removeElement($campaignProduct);
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public abstract function getProductImages(): Collection;

    abstract public function addImage(Image $image): self;

    abstract public function removeImage(Image $image): self;

    public abstract function addProductImage(ProductImage $productImage): self;

    public abstract function removeProductImage(ProductImage $productImage): self;

}
