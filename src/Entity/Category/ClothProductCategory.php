<?php

namespace App\Entity\Category;

use App\Entity\BillLine;
use App\Entity\Product\ClothProduct;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class ClothProductCategory extends BillLine implements ProductCategoryInterface
{

    private ClothProduct $product;

    public function getClothProduct(): ClothProduct
    {
        return $this->product;
    }

    public function setClothProduct(ClothProduct $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
