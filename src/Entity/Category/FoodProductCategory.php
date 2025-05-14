<?php

namespace App\Entity\Category;

use App\Entity\BillLineProduct;
use App\Entity\Product\FoodProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class FoodProductCategory extends BillLineProduct implements ProductCategoryInterface
{
    private FoodProduct $category;

    public function getCategory(): FoodProduct
    {
        return $this->category;
    }
    public function setCategory(FoodProduct $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Food';
    }

}
