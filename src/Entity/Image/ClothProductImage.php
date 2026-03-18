<?php

namespace App\Entity\Image;

use App\Entity\ProductImage;
use App\Repository\ProductImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
class ClothProductImage extends ProductImage
{
}
