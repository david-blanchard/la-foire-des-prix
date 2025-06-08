<?php

namespace App\Entity\Product;

use App\Entity\Campaign;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductInterface;
use App\Repository\HomeProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomeProductRepository::class)]
#[ORM\Table(name: 'home_products')]
class HomeProduct extends Product implements ProductInterface
{
    #[ORM\OneToMany(targetEntity: Image\HomeProductImage::class, mappedBy: 'productClass', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $productImages;

    public function __construct()
    {
        parent::__construct();
        $this->productImages = new ArrayCollection();
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }

    public function addCampaignProduct(Campaign\HomeProductCampaign $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
            $campaignProduct->setProductClass($this);
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\HomeProductImage();
        $productImage->setProductClass($this);
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\HomeProductImage();
        $productImage->setProductClass($this);
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }

    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImage $productImage): Product
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): Product
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
        }

        return $this;
    }
}
