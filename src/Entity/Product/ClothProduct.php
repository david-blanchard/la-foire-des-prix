<?php

namespace App\Entity\Product;

use App\Entity\Category\ProductCategoryInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'cloth_products')]
class ClothProduct extends Product implements ProductCategoryInterface
{
    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
