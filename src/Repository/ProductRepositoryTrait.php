<?php

namespace App\Repository;

use App\Entity\CampaignProduct;

trait ProductRepositoryTrait
{
    /**
     * Retrieve the discount of a product by its ID.
     *
     * @return int Discount percentage
     */
    public function getProductDiscountById(?int $productId): int
    {
        return 1;
    }
}
