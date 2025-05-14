<?php

namespace App\Entity\Category;

use App\Entity\BillLineProduct;
use App\Entity\Product\ClothProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class ClothProductCategory extends BillLineProduct implements ProductCategoryInterface
{

    private ClothProduct $category;

    public function getCategory(): ClothProduct
    {
        return $this->category;
    }

    public function setCategory(ClothProduct $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
