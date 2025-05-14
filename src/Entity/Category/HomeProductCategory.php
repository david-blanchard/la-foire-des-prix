<?php

namespace App\Entity\Category;

use App\Entity\BillLineProduct;
use App\Entity\Product\HomeProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class HomeProductCategory extends BillLineProduct implements ProductCategoryInterface
{
    private HomeProduct $category;

    public function getCategory(): HomeProduct
    {
        return $this->category;
    }

    public function setCategory(HomeProduct $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }

}
