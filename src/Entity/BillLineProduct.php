<?php

namespace App\Entity;

use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\BillRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['bill-line.read', 'product.read', 'bill.read'],
    ],
    denormalizationContext: [
        'groups' => ['bill-line.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: BillRepository::class)]
#[ORM\Table(name: 'bill_lines')]
class BillLineProduct
{
    use Identifier;
    use Classifier;

    #[ORM\Column(length: 255)]
    #[Groups(['bill-line.read', 'bill-line.write'])]
    protected ?string $name = null;

    #[ORM\Column(type: 'smallint', options: ['unsigned' => true])]
    #[Groups(['bill-line.read', 'bill-line.write'])]
    private int $quantity;

    #[ORM\ManyToOne(inversedBy: 'billLines')]
    #[Groups([
        'bill-line.read',
        'bill-line.write',
        'bill.read',
    ])]
    private ?Bill $bill = null;

    #[ORM\ManyToOne]
    #[Groups([
        'bill-line.read',
        'bill-line.write',
        'product.read',
    ])]
    private ?Product $product = null;

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getBill(): Bill
    {
        return $this->bill;
    }

    public function setBill(?Bill $bill): static
    {
        $this->bill = $bill;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
