<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductInterface;
use App\Repository\ClothProductCampaignRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductCampaignRepository::class)]
class ClothProductCampaign extends CampaignProduct
{
    #[ORM\ManyToOne(targetEntity: ClothProduct::class, inversedBy: 'campaigns')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ClothProduct $productClass;

    public function getProductClass(): ?ClothProduct
    {
        return $this->productClass;
    }

    public function setProductClass(ClothProduct|null $productClass): static
    {
        $this->productClass = $productClass;

        return $this;
    }
}
