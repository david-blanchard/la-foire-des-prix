<?php

namespace App\Repository;

use Symfony\Component\Uid\Uuid;

trait ProductRepositoryTrait
{
    /**
     * Retrieve the discount of a product by its ID.
     *
     * @return int Discount percentage
     */
    public function getProductDiscountById(?Uuid $productId): int
    {
        return 1;
    }
}
