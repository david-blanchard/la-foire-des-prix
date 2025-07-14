<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Campaign\ClothProductCampaign;
use App\Entity\Campaign\FoodProductCampaign;
use App\Entity\Campaign\HomeProductCampaign;
use App\Entity\Traits\Identifier;
use App\Repository\CampaignProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ApiResource(
    mercure: true,
    normalizationContext: [
        'groups' => ['campaign_product.read', 'product.read', 'campaign.read'],
    ],
    denormalizationContext: [
        'groups' => ['campaign_product.write'],
    ]
)]
#[ORM\Entity(repositoryClass: CampaignProductsRepository::class)]
#[ORM\Table(name: 'campaign_products')]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'campaign_type', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductCampaign::class,
    'food' => FoodProductCampaign::class,
    'home' => HomeProductCampaign::class,
])]
abstract class CampaignProduct
{
    use Identifier;

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'campaignProducts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups([
        'campaign_product.read',
        'campaign_product.write',
        'campaign.read',
    ])]
    protected ?Campaign $campaign;

    /**
     * @var Collection<int, ProductInterface|null>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'campaignProducts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups([
        'campaign_product.read',
        'campaign_product.write',
        'product.read',
    ])]
    protected Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    //    public abstract function setProduct(ProductInterface|null $product): self;

    /**
     * @return Collection<int, ProductInterface|null>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductInterface|null $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(ProductInterface|null $product): static
    {
        $this->products->removeElement($product);

        return $this;
    }
}
