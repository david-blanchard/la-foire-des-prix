<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Identifier;
use App\Repository\CampaignProductsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['campaign-product.read', 'product.read', 'campaign.read'],
    ],
    denormalizationContext: [
        'groups' => ['campaign-product.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: CampaignProductsRepository::class)]
#[ORM\Table(name: 'campaign_products')]
class CampaignProduct
{
    use Identifier;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups([
        'campaign-product.read',
        'campaign-product.write',
        'campaign.read',
    ])]
    protected ?Campaign $campaign = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups([
        'campaign-product.read',
        'campaign-product.write',
        'product.read',
    ])]
    protected ?Product $product = null;

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
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
}
