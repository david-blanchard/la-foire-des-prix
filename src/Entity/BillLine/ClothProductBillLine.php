<?php

namespace App\Entity\BillLine;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\BillLineProduct;
use App\Entity\Product\ClothProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'cloth_product_bill_line')]
class ClothProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    public readonly string $bill_type;

    public function __construct()
    {
        parent::__construct();
        $this->bill_type = ClothProduct::class;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
