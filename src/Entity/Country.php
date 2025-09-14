<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['country.read'],
    ],
    denormalizationContext: [
        'groups' => ['country.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\Column(length: 3, unique: true)]
    #[Groups(['country.read', 'country.write'])]
    private string $code = 'FR';

    #[ORM\Column(length: 128)]
    #[Groups(['country.read', 'country.write'])]
    private string $name = 'France';

    /**
     * @var Collection<int, City>
     */
    #[ORM\OneToMany(targetEntity: City::class, mappedBy: 'country')]
    #[Groups(['country.read', 'country.write'])]
    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountry($this);
        }

        return $this;
    }

    public function removeCity(City $city): static
    {
        if ($this->cities->removeElement($city)) {
            // On ne peut pas mettre null car la relation est non-nullable
        }

        return $this;
    }
}
