<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['address.read'],
    ],
    denormalizationContext: [
        'groups' => ['address.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource]
class Address
{
    use Traits\Identifier;

    #[ORM\Column(length: 255)]
    #[Groups(['address.read', 'address.write'])]
    private ?string $line1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address.read', 'address.write'])]
    private ?string $line2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['address.read', 'address.write'])]
    private ?string $details = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['address.read', 'address.write'])]
    private ?City $city = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'address')]
    private Collection $occupant;

    public function __construct()
    {
        $this->occupant = new ArrayCollection();
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): static
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): static
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOccupant(): Collection
    {
        return $this->occupant;
    }

    public function addOccupant(User $occupant): static
    {
        if (!$this->occupant->contains($occupant)) {
            $this->occupant->add($occupant);
            $occupant->addAddress($this);
        }

        return $this;
    }

    public function removeOccupant(User $occupant): static
    {
        if ($this->occupant->removeElement($occupant)) {
            $occupant->removeAddress($this);
        }

        return $this;
    }

}
