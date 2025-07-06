<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class ClothProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    public readonly string $relation;

    public function __construct()
    {
        parent::__construct();
        $this->relation = ClothProduct::class;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
