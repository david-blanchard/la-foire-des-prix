<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CampaignProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignProductRepository::class)]
#[ApiResource]
class CampaignProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'campaignProducts')]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'campaignProducts')]
    private ?Campaign $campaign = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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
