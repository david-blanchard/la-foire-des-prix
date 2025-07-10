<?php

namespace App\Entity\Product;

use App\Entity\Campaign;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Repository\FoodProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodProductRepository::class)]
#[ORM\Table(name: 'food_product')]
class FoodProduct extends Product implements ProductInterface
{
    public readonly ?string $product_type;

    public function __construct()
    {
        $this->product_type = FoodProduct::class;
        parent::__construct();
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }

    public function addCampaignProduct(Campaign\FoodProductCampaign $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\FoodProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\FoodProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }
}
