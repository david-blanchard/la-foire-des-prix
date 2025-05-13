<?php

namespace App\Entity\Category;

use App\Entity\BillLine;
use App\Entity\Product\FoodProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class FoodProductCategory extends BillLine implements ProductCategoryInterface
{
    private FoodProduct $product;

    public function getFoodProduct(): FoodProduct
    {
        return $this->product;
    }
    public function setFoodProduct(FoodProduct $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }

}
