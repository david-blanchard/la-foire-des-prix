<?php

namespace App\Entity;

use App\Entity\BillLine\ClothProductBillLine;
use App\Entity\BillLine\FoodProductBillLine;
use App\Entity\BillLine\HomeProductBillLine;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'relation', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductBillLine::class,
    'food' => FoodProductBillLine::class,
    'home' => HomeProductBillLine::class,
])]
class BillLineProduct
{
    use Identifier;
    use Classifier;

    #[ORM\Column(type: 'smallint', options: ['unsigned' => true])]
    private int $quantity;

    #[ORM\ManyToOne(inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false)]
    private Bill $bill;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
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
