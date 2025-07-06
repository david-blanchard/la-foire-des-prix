<?php

namespace App\Entity;

use App\Entity\Campaign\ClothProductCampaign;
use App\Entity\Campaign\FoodProductCampaign;
use App\Entity\Campaign\HomeProductCampaign;
use App\Entity\Traits\Identifier;
use App\Repository\CampaignProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignProductsRepository::class)]
#[ORM\Table(name: 'campaign_products')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'relation', type: 'string')]
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
    private ?Campaign $campaign;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'campaignProducts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Collection $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
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
 * @return Collection<int, Product>
 */
public function getProduct(): Collection
{
    return $this->product;
}

public function addProduct(Product $product): static
{
    if (!$this->product->contains($product)) {
        $this->product->add($product);
    }

    return $this;
}

public function removeProduct(Product $product): static
{
    $this->product->removeElement($product);

    return $this;
}

}
