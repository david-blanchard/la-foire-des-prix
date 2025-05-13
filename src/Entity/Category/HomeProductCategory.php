<?php

namespace App\Entity\Category;

use App\Entity\BillLine;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class HomeProductCategory extends BillLine implements ProductCategoryInterface
{
    private HomeProduct $product;

    public function getHomeProduct(): HomeProduct
    {
        return $this->product;
    }

    public function setHomeProduct(HomeProduct $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getCategoryName(): string
    {
        return 'Home';
    }

}
