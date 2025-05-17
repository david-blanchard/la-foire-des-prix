<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\FoodProduct;
use App\Entity\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class FoodProductCampaign extends CampaignProduct
{
    #[ORM\ManyToOne(targetEntity: FoodProduct::class, inversedBy: 'campaigns')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?FoodProduct $product;

    public function getProduct(): ?FoodProduct
    {
        return $this->product;
    }

    public function setProduct(FoodProduct|null $product): static
    {
        $this->product = $product;

        return $this;
    }
}
