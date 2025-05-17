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
    private ?HomeProduct $product;

    public function getProduct(): ?HomeProduct
    {
        return $this->product;
    }

    public function setProduct(HomeProduct|null $product): static
    {
        $this->product = $product;

        return $this;
    }
}
