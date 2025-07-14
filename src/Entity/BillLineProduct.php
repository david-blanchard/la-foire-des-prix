<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\BillLine\ClothProductBillLine;
use App\Entity\BillLine\FoodProductBillLine;
use App\Entity\BillLine\HomeProductBillLine;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    mercure: true,
    normalizationContext: [
        'groups' => ['bill-line.read', 'product.read', 'bill.read'],
    ],
    denormalizationContext: [
        'groups' => ['bill-line.write'],
    ]
)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'bill_type', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductBillLine::class,
    'food' => FoodProductBillLine::class,
    'home' => HomeProductBillLine::class,
])]
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
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'bill-line.read',
        'bill-line.write',
        'bill.read',
    ])]
    private Bill $bill;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'bill-line.read',
        'bill-line.write',
        'product.read',
    ])]
    private ?Product $product = null;

    public function __construct()
    {
    }

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

    public function setBill(Bill $bill): self
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
