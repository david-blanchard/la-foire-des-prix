<?php

namespace App\Entity\Product;

use App\Entity\ProductInterface;
use App\Entity\Traits\Product;
use App\Repository\FoodProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodProductRepository::class)]
#[ORM\Table(name: 'food_products')]
class FoodProduct implements ProductInterface
{
    use Product;

    public function getCategoryName(): string
    {
        return 'Food';
    }
}
