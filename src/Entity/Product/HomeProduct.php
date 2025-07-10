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
#[ORM\Table(name: 'home_product')]
class HomeProduct extends Product implements ProductInterface
{
    public readonly ?string $product_type;

    public function __construct()
    {
        $this->product_type = HomeProduct::class;
        parent::__construct();
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }

    public function addCampaignProduct(Campaign\HomeProductCampaign $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\HomeProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\HomeProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }

}
