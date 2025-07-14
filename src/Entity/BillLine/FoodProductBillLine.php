<?php

namespace App\Entity\BillLine;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\BillLineProduct;
use App\Entity\Product\FoodProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'food_product_bill_line')]
class FoodProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    public readonly string $bill_type;

    public function __construct()
    {
        parent::__construct();
        $this->bill_type = FoodProduct::class;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }
}
