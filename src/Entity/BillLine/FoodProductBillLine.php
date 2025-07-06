<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\FoodProduct;
use App\Entity\ProductInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class FoodProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    public readonly string $relation;

    public function __construct()
    {
        parent::__construct();
        $this->relation = FoodProduct::class;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }
}
