<?php

namespace App\Entity\Product;

use App\Entity\ProductInterface;
use App\Entity\Traits\Product;
use App\Repository\ClothProductRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ClothProductRepository::class)]
#[ORM\Table(name: 'cloth_products')]
class ClothProduct implements ProductInterface
{
    use Product;

    public function getCategoryName(): string
    {
        return 'Clothes';
    }
}
