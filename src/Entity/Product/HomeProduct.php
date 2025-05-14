<?php

namespace App\Entity\Product;

use App\Entity\ProductInterface;
use App\Entity\Traits\Product;
use App\Repository\HomeProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomeProductRepository::class)]
#[ORM\Table(name: 'home_products')]
class HomeProduct implements ProductInterface
{
    use Product;

    public function getCategoryName(): string
    {
        return 'Home';
    }
}
