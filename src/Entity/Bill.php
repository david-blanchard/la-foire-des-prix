<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Identifier;
use App\Repository\BillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    mercure: true,
    normalizationContext: [
        'groups' => ['bill.read'],
    ],
    denormalizationContext: [
        'groups' => ['bill.write'],
    ]
)]
#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    use Identifier;
    use TimestampableEntity;

    /**
     * @var Collection<int, BillLineProduct>
     */
    #[ORM\OneToMany(mappedBy: 'bill', targetEntity: BillLineProduct::class, cascade: ['persist', 'remove'])]
    private Collection $billLines;

    #[ORM\Column]
    #[Groups(['bill.read', 'bill.write'])]
    private ?float $vat = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
    #[Groups(['bill.read', 'bill.write'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->billLines = new ArrayCollection();
    }

    /**
     * @return Collection<int, BillLineProduct>
     */
    public function getBillLines(): Collection
    {
        return $this->billLines;
    }

    public function addBillLine(BillLineProduct $product): static
    {
        if (!$this->billLines->contains($product)) {
            $this->billLines->add($product);
        }

        return $this;
    }

    public function removeBillLine(BillLineProduct $product): static
    {
        $this->billLines->removeElement($product);

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
