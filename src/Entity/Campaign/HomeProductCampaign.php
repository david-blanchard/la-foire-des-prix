<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class HomeProductCampaign extends CampaignProduct
{
    #[ORM\ManyToOne(targetEntity: HomeProduct::class, inversedBy: 'campaigns')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?HomeProduct $productClass;

    public function getProductClass(): ?HomeProduct
    {
        return $this->productClass;
    }

    public function setProductClass(HomeProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }
}
