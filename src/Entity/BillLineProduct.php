<?php

namespace App\Entity;

use App\Entity\Category\ClothProductCategory;
use App\Entity\Category\FoodProductCategory;
use App\Entity\Category\HomeProductCategory;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'category', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductCategory::class,
    'food' => FoodProductCategory::class,
    'home' => HomeProductCategory::class,
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
