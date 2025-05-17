<?php

namespace App\Entity;

use App\Entity\Traits\Identifier;
use App\Repository\CampaignProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignProductsRepository::class)]
#[ORM\Table(name: 'campaign_products')]
class CampaignProduct
{
    use Identifier;

    #[ORM\ManyToOne(inversedBy: 'campaignProducts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Campaign $campaign;

    #[ORM\ManyToOne(inversedBy: 'campaignProducts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ProductInterface $product;

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    public function setProduct(?ProductInterface $product): self
    {
        $this->product = $product;

        return $this;
    }
}
