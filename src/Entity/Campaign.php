<?php

namespace App\Entity;

use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: 'campaigns')]
class Campaign
{
    use Identifier;
    use Classifier;
    use TimestampableEntity;

    #[ORM\Column(type: 'date_immutable')]
    private DateTimeImmutable $startsAt;

    #[ORM\Column(type: 'date_immutable')]
    private DateTimeImmutable $endsAt;

    #[ORM\Column(type: 'smallint')]
    private int $discount;

    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: CampaignProduct::class, cascade: ['persist', 'remove'])]
    private Collection $campaignProducts;

    public function __construct()
    {
        $this->campaignProducts = new ArrayCollection();
    }

    public function getStartsAt(): DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function setStartsAt(DateTimeImmutable $start): self
    {
        $this->startsAt = $start;
        return $this;
    }

    public function getEndsAt(): DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function setEndsAt(DateTimeImmutable $end): self
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
            if ($this->campaignProducts->removeElement($campaignProduct)) {
                $campaignProduct = null;
            }
        }

        return $this;
    }
}
