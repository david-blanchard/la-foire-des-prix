<?php

namespace App\Entity;

use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
class Product
{

    use Identifier;
    use Classifier;
    use TimestampableEntity;

    #[ORM\Column(length: 1024)]
    private string $description;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $moreInfo = null;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private Brand $brand;

    #[ORM\OneToMany(targetEntity: CampaignProduct::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $campaignProducts;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $productImages;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?BillLine $category = null;

    public function __construct()
    {
        $this->campaignProducts = new ArrayCollection();
        $this->productImages = new ArrayCollection();
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

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getCampaignProducts(): Collection
    {
        return $this->campaignProducts;
    }

    public function addCampaignProduct(CampaignProduct $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
            $campaignProduct->setProduct($this);
        }
        return $this;
    }

    public function removeCampaignProduct(CampaignProduct $campaignProduct): self
    {
        if ($this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts->removeElement($campaignProduct);
        }

        return $this;
    }

    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addImage(Image $image): self
    {
        $productImage = new ProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new ProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }

    public function addProductImage(ProductImage $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
        }
        return $this;
    }

    public function removeProductImage(ProductImage $productImage): self
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
        }

        return $this;
    }

    public function getCategory(): ?BillLine
    {
        return $this->category;
    }

    public function setCategory(?BillLine $category): static
    {
        $this->category = $category;

        return $this;
    }
}
