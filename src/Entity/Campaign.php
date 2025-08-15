<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\CampaignRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'enable_max_depth' => true,
        'groups' => ['campaign.read'],
    ],
    denormalizationContext: [
        'groups' => ['campaign.write'],
    ],
    mercure: true
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
    protected ?DateTimeImmutable $startsAt = null;

    #[ORM\Column(type: 'date_immutable')]
    #[Groups(['campaign.read', 'campaign.write'])]
    protected ?DateTimeImmutable $endsAt = null;

    #[ORM\Column(type: 'smallint')]
    #[Groups(['campaign.read', 'campaign.write'])]
    protected ?int $discount = null;

    public function getStartsAt(): ?DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function setStartsAt(DateTimeImmutable $startsAt): static
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getEndsAt(): ?DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function setEndsAt(DateTimeImmutable $endsAt): static
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }
}
