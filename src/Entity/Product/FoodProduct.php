<?php

namespace App\Entity\Product;

use App\Entity\Campaign\FoodProductCampaign;
use App\Entity\CampaignProduct;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Repository\FoodProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodProductRepository::class)]
#[ORM\Table(name: 'food_products')]
class FoodProduct extends Product implements ProductInterface
{
    public function getCategoryName(): string
    {
        return 'Food';
    }

    public function addCampaignProduct(FoodProductCampaign $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
            $campaignProduct->setProduct($this);
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\FoodProductImage();
        $productImage->setProduct($this);
        $productImage->setProductId($this->getId());
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\FoodProductImage();
        $productImage->setProduct($this);
        $productImage->setProductId($this->getId());
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }
}
