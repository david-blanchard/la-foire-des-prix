<?php

namespace App\Entity;

use App\Entity\Category\ProductCategoryInterface;

interface ProductInterface extends ProductCategoryInterface
{
    public function getDescription(): string;
    public function getMoreInfo(): ?string;
    public function getPrice(): float;
    public function getBrand(): ?Brand;
}
