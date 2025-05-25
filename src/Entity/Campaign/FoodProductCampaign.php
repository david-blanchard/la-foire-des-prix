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
    private ?FoodProduct $productClass;

    public function getProductClass(): ?FoodProduct
    {
        return $this->productClass;
    }

    public function setProductClass(FoodProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }
}
