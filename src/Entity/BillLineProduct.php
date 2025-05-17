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
#[ORM\DiscriminatorColumn(name: 'product', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductBillLine::class,
    'food' => FoodProductBillLine::class,
    'home' => HomeProductBillLine::class,
])]
class BillLineProduct
{
    use Identifier;
    use Classifier;

    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private int $productId;

    #[ORM\Column(type: 'smallint', options: ['unsigned' => true])]
    private int $quantity;

    #[ORM\ManyToOne(inversedBy: 'billLines')]
    #[ORM\JoinColumn(nullable: false)]
    private Bill $bill;

    public function __construct()
    {
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
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
}
