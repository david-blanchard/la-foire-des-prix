<?php

namespace App\Entity\Product;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Campaign;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Repository\ClothProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: ClothProductRepository::class)]
#[ORM\Table(name: 'cloth_product')]
class ClothProduct extends Product implements ProductInterface
{
    public readonly ?string $product_type;

    public function __construct()
    {
        $this->product_type = ClothProduct::class;
        parent::__construct();
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }

    public function addCampaignProduct(Campaign\ClothProductCampaign $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
        }

        return $this;
    }

    public function addImage(Image $image): self
    {
        $productImage = new Image\ClothProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $productImage = new Image\ClothProductImage();
        $productImage->setProduct($this);
        $productImage->setImage($image);

        $this->removeProductImage($productImage);

        return $this;
    }
}
