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
    normalizationContext: [
        'groups' => ['bill.read'],
    ],
    denormalizationContext: [
        'groups' => ['bill.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: BillRepository::class)]
#[ORM\Table(name: 'bills')]
class Bill
{
    use Identifier;
    use TimestampableEntity;

    /**
     * @var Collection<int, BillLineProduct>
     */
    #[ORM\OneToMany(targetEntity: BillLineProduct::class, mappedBy: 'bill')]
    private Collection $billLines;

    #[ORM\Column]
    #[Groups(['bill.read', 'bill.write'])]
    private ?float $vat = null;

    #[ORM\ManyToOne]
    #[Groups(['bill.read', 'bill.write'])]
    private ?User $client = null;

    public function __construct()
    {
        $this->billLines = new ArrayCollection();
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

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): static
    {
        $this->client = $client;

        return $this;
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
            $product->setBill($this);
        }

        return $this;
    }

    public function removeBillLine(BillLineProduct $billLine): static
    {
        if ($this->billLines->removeElement($billLine)) {
            // set the owning side to null (unless already changed)
            if ($billLine->getBill() === $this) {
                $billLine->setBill(null);
            }
        }

        return $this;
    }
}
