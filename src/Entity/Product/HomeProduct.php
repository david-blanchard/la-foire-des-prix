<?php

namespace App\Entity\Product;

use App\Entity\Category\ProductCategoryInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'home_products')]
class HomeProduct extends Product implements ProductCategoryInterface
{

    public function getCategoryName(): string
    {
        return 'Home';
    }
}
