<?php

namespace App\Entity;

use App\Entity\Image\ClothProductImage;
use App\Entity\Product\ClothProduct;
use App\Entity\Traits\Identifier;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\Table(name: 'images')]
class Image
{
    use Identifier;
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'string', length: 255)]
    private string $alt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    /**
     * @var Collection<int, ProductImage> $productImages
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'image', cascade: ['persist', 'remove'])]
    private Collection $productImages;

    public function __construct()
    {
        $this->productImages = new ArrayCollection();
    }

    // Getters et setters...

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addImage(ClothProduct $product): self
    {
        $productImage = new ClothProductImage();
        $productImage->setImage($this);
        $productImage->setProduct($product);
        $productImage->setRelation($product->getCategoryName());

        $this->addProductImage($productImage);

        return $this;
    }

    public function removeImage(ClothProduct $product): self
    {
        $productImage = new ClothProductImage();
        $productImage->setImage($this);
        $productImage->setProduct($product);
        $productImage->setRelation($product->getCategoryName());

        $this->removeProductImage($productImage);

        return $this;
    }

    public function addProductImage(ProductImage $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): self
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
        }

        return $this;
    }
}
