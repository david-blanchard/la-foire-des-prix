<?php

namespace App\Dto;

use App\Entity\Image;

class ProductViewProperties
{
    private ?int $id;
    private ?string $name;
    private ?string $description;
    private ?string $moreInfo;
    private float $price;
    private ?string $brand;
    private float $discountRate;
    private float $discount;
    private string $featuresCaption;
    /**
     * @var array<mixed>
     */
    private array $features;
    /**
     * @var array<mixed>
     */
    private array $images;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'moreInfo' => $this->getMoreInfo(),
            'price' => $this->getPrice(),
            'brand' => $this->getBrand(),
            'discountRate' => $this->getDiscountRate(),
            'discount' => $this->getDiscount(),
            'featuresCaption' => $this->getFeaturesCaption(),
            'features' => $this->getFeatures(),
            'images' => $this->getImages(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ProductViewProperties
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): ProductViewProperties
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ProductViewProperties
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreInfo(): ?string
    {
        return $this->moreInfo;
    }

    public function setMoreInfo(?string $moreInfo): ProductViewProperties
    {
        $this->moreInfo = $moreInfo;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): ProductViewProperties
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): ProductViewProperties
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDiscountRate(): float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(float $discountRate): ProductViewProperties
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): ProductViewProperties
    {
        $this->discount = $discount;

        return $this;
    }

    public function getFeaturesCaption(): string
    {
        return $this->featuresCaption;
    }

    public function setFeaturesCaption(string $featuresCaption): ProductViewProperties
    {
        $this->featuresCaption = $featuresCaption;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * @param string[] $features
     */
    public function setFeatures(array $features): ProductViewProperties
    {
        $this->features = $features;

        return $this;
    }

    /* @return Image[] */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param Image[] $images
     */
    public function setImages(array $images): ProductViewProperties
    {
        $this->images = $images;

        return $this;
    }
}
