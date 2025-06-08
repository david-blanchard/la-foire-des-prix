<?php

namespace App\Entity\Product;

use App\Entity\Campaign;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Repository\ClothProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductRepository::class)]
#[ORM\Table(name: 'cloth_products')]
class ClothProduct extends Product implements ProductInterface
{

    #[ORM\OneToMany(targetEntity: Image\ClothProductImage::class, mappedBy: 'productClass', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $productImages;

    public function __construct()
    {
        parent::__construct();
        $this->productImages = new ArrayCollection();
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }

    public function addCampaignProduct(Campaign\ClothProductCampaign $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
            $campaignProduct->setProductClass($this);
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\ClothProductImage();
        $productImage->setProductClass($this);
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\ClothProductImage();
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

    public function addProductImage(Image\ClothProductImage|\App\Entity\ProductImage $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
        }

        return $this;
    }

    public function removeProductImage(Image\ClothProductImage|\App\Entity\ProductImage $productImage): self
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
        }

        return $this;
    }
}
