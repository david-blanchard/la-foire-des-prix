<?php

namespace App\Entity;

use App\Entity\Base\IdentifierTrait;
use App\Repository\CampaignProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignProductRepository::class)]
class CampaignProduct
{
    use IdentifierTrait;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'campaignProducts')]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'campaignProducts')]
    private ?Campaign $campaign = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
    }

}
