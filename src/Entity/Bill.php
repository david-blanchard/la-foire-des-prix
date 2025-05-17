<?php

namespace App\Entity;

use App\Entity\Traits\Identifier;
use App\Repository\BillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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
    private ?float $vat = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
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
