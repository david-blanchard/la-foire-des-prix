<?php

namespace App\Entity\BillLine;

use App\Entity\BillLineProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\ProductInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'home_product_bill_line')]
class HomeProductBillLine extends BillLineProduct implements ProductBillLineInterface
{
    public readonly string $bill_type;

    public function __construct()
    {
        parent::__construct();
        $this->bill_type = HomeProduct::class;
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }
}
