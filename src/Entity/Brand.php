<?php

namespace App\Entity;

use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\BrandRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ORM\Table(name: 'brands')]
class Brand
{

    use Identifier;
    use TimestampableEntity;
    use Classifier;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Product::class, cascade: ['persist', 'remove'])]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}

// I will now proceed to write the full Campaign, Product, CampaignProduct, Image, ProductImage, and User entities in the same style with complete getters, setters, and relation management.
