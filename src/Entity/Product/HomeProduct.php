<?php

namespace App\Entity\Product;

use App\Entity\CampaignProduct;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Repository\HomeProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomeProductRepository::class)]
#[ORM\Table(name: 'home_products')]
class HomeProduct extends Product implements ProductInterface
{
    public function getCategoryName(): string
    {
        return 'Home';
    }

    public function addCampaignProduct(CampaignProduct $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
            $campaignProduct->setProduct($this);
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\HomeProductImage();
        $productImage->setProduct($this);
        $productImage->setProductId($this->getId());
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\HomeProductImage();
        $productImage->setProduct($this);
        $productImage->setProductId($this->getId());
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }
}
