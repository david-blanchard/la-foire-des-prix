<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Identifier;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['image.read'],
    ],
    denormalizationContext: [
        'groups' => ['image.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\Table(name: 'images')]
class Image
{
    use Identifier;
    use TimestampableEntity;

    #[ORM\Column(length: 255)]
    #[Groups(['image.read', 'image.write'])]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Groups(['image.read', 'image.write'])]
    private ?string $alt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['image.read', 'image.write'])]
    private ?string $title = null;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'image', cascade: ['persist', 'remove'])]
    private Collection $productImages;

    public function __construct()
    {
        $this->productImages = new ArrayCollection();
    }

    public function getData(): array
    {
        return [
            'url' => $this->getUrl(),
            'alt' => $this->getAlt(),
            'title' => $this->getTitle(),
        ];
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
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

    public function addProductImage(ProductImage $productImage): static
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages->add($productImage);
            $productImage->setImage($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): static
    {
        if ($this->productImages->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getImage() === $this) {
                $productImage->setImage(null);
            }
        }

        return $this;
    }
}
