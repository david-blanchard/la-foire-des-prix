<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Image
{
 #[ORM\Id]
 #[ORM\GeneratedValue]
 #[ORM\Column(type: 'integer')]
 private ?int $id = null;

 #[ORM\Column(type: 'string', length: 255)]
 private ?string $url = null;

 #[ORM\Column(type: 'string', length: 255, nullable: true)]
 private ?string $alt = null;

 #[ORM\Column(type: 'string', length: 255, nullable: true)]
 private ?string $title = null;

 #[ORM\OneToMany(mappedBy: 'image', targetEntity: ProductImages::class, cascade: ['persist', 'remove'])]
 private Collection $productImages;

 public function __construct()
 {
     $this->productImages = new ArrayCollection();
 }

 public function getId(): ?int
 {
     return $this->id;
 }

 public function getUrl(): ?string
 {
     return $this->url;
 }

 public function setUrl(string $url): self
 {
     $this->url = $url;

     return $this;
 }

 public function getAlt(): ?string
 {
     return $this->alt;
 }

 public function setAlt(?string $alt): self
 {
     $this->alt = $alt;

     return $this;
 }

 public function getTitle(): ?string
 {
     return $this->title;
 }

 public function setTitle(?string $title): self
 {
     $this->title = $title;

     return $this;
 }

 public function getProductImages(): Collection
 {
     return $this->productImages;
 }

 public function addProductImage(ProductImages $productImage): self
 {
     if (!$this->productImages->contains($productImage)) {
         $this->productImages[] = $productImage;
         $productImage->setImage($this);
     }

     return $this;
 }

 public function removeProductImage(ProductImages $productImage): self
 {
     if ($this->productImages->removeElement($productImage)) {
         if ($productImage->getImage() === $this) {
             $productImage->setImage(null);
         }
     }

     return $this;
 }
}
