<?php

namespace App\Entity;

use App\Entity\Product\ClothProduct;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ORM\Table(name: 'brands')]
class Brand
{
    use Identifier;
    use TimestampableEntity;
    use Classifier;

    /**
     * @var Collection<int, ClothProduct> $products
     */
    #[ORM\OneToMany(targetEntity: ClothProduct::class, mappedBy: 'brand', cascade: ['persist', 'remove'])]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection<int, ClothProduct>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @return $this
     */
    public function addProduct(ClothProduct $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(ClothProduct $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}
