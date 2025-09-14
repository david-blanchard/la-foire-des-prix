<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['city.read'],
    ],
    denormalizationContext: [
        'groups' => ['city.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    use Traits\Identifier;

    #[ORM\Column(length: 255)]
    #[Groups(['city.read', 'city.write'])]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Groups(['city.read', 'city.write'])]
    private ?string $zipcode = null;

    /**
     * @var Country
     */
    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'cities')]
    #[ORM\JoinColumn(name: 'country_code', referencedColumnName: 'code', nullable: false)]
    #[Groups(['city.read', 'city.write'])]
    private Country $country;

    public function __construct()
    {
        // Plus besoin d'initialiser $country comme une Collection
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

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): static
    {
        $this->country = $country;

        return $this;
    }

}
