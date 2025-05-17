<?php

namespace App\Entity;

use App\Entity\Campaign\ClothProductCampaign;
use App\Entity\Campaign\FoodProductCampaign;
use App\Entity\Campaign\HomeProductCampaign;
use App\Entity\Traits\Identifier;
use App\Repository\CampaignProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignProductsRepository::class)]
#[ORM\Table(name: 'campaign_products')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'product', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductCampaign::class,
    'food' => FoodProductCampaign::class,
    'home' => HomeProductCampaign::class,
])]
class CampaignProduct
{
    use Identifier;

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'campaignProducts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Campaign $campaign;

    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $productId;

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }
}
