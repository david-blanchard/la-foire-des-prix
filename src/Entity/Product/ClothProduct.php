<?php

namespace App\Entity\Product;

use App\Entity\Campaign\ClothProductCampaign;
use App\Entity\CampaignProduct;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Repository\ClothProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductRepository::class)]
#[ORM\Table(name: 'cloth_products')]
class ClothProduct extends Product implements ProductInterface
{
    public function getCategoryName(): string
    {
        return 'Clothes';
    }

    public function addCampaignProduct(ClothProductCampaign $campaignProduct): self
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
}
