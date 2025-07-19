<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    mercure: true,
    normalizationContext: [
        'enable_max_depth' => true,
        'groups' => ['campaign.read'],
    ],
    denormalizationContext: [
        'groups' => ['campaign.write'],
    ]
)]
#[ORM\Entity(repositoryClass: CampaignRepository::class)]
#[ORM\Table(name: 'campaigns')]
class Campaign
{
    use Identifier;
    use Classifier;
    use TimestampableEntity;

    #[ORM\Column(length: 255)]
    #[Groups(['campaign.read', 'campaign.write'])]
    protected ?string $name = null;

    #[ORM\Column(type: 'date_immutable')]
    #[Groups(['campaign.read', 'campaign.write'])]
    protected \DateTimeImmutable $startsAt;

    #[ORM\Column(type: 'date_immutable')]
    #[Groups(['campaign.read', 'campaign.write'])]
    protected \DateTimeImmutable $endsAt;

    #[ORM\Column(type: 'smallint')]
    #[Groups(['campaign.read', 'campaign.write'])]
    protected int $discount;

    /**
     * @var Collection<int, CampaignProduct> $campaignProducts
     */
    #[ORM\OneToMany(targetEntity: CampaignProduct::class, mappedBy: 'campaign', cascade: ['persist', 'remove'])]
    protected Collection $campaignProducts;

    public function __construct()
    {
        $this->campaignProducts = new ArrayCollection();
    }

    public function getStartsAt(): \DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeImmutable $start): self
    {
        $this->startsAt = $start;

        return $this;
    }

    public function getEndsAt(): \DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeImmutable $end): self
    {
        $this->endsAt = $end;

        return $this;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection<int, CampaignProduct>
     */
    public function getCampaignProducts(): Collection
    {
        return $this->campaignProducts;
    }

    public function addCampaignProduct(CampaignProduct $campaignProduct): self
    {
        if (!$this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts[] = $campaignProduct;
            $campaignProduct->setCampaign($this);
        }

        return $this;
    }

    public function removeCampaignProduct(CampaignProduct $campaignProduct): self
    {
        if ($this->campaignProducts->contains($campaignProduct)) {
            $this->campaignProducts->removeElement($campaignProduct);
        }

        return $this;
    }
}
