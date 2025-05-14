<?php

namespace App\Service;

use App\Repository\ClothProductRepository;
use App\Repository\ImageRepository;

class ProductService implements ViewServiceInterface
{
    public function __construct(
        private readonly CustomCacheInterface  $cache,
        private readonly ClothProductRepository $productRepository,
        private readonly ImageRepository       $imagesRepository,
    ) {
    }

    /**
     * Transform ProductInfo attributes in properties usable in views
     *
     * @param array $props
     * @return array
     */
    public function prepareViewFields(?object $data = null): array
    {

        $discount = $this->productRepository->getProductDiscountById($data->getId());
        $props = [];
        $props['name'] = $data->getName();
        $props['id'] = $data->getId();
        $props['description'] = $data->getDescription();
        $props['moreInfo'] = $data->getMoreInfo();
        $props['price'] = $data->getPrice();
        $props['brand'] = $data->getBrand()->getName();
        $props['discountRate'] = $discount;
        $props['discount'] = $this->computeDiscount($data->getPrice(), $discount);

        $props['featuresCaption'] = 'Information complémentaires';
        $props['features'] = $this->grabMoreInfo($data->getMoreInfo());

        $images = $this->imagesRepository->findByProductId($data->getId());
        $props['images'] = $images;

        return $props;
    }

    /**
     * Compute the discounted price of a product
     *
     * @param float|string $price Original price
     * @param int $percent Discount percentage
     * @return float Discounted price
     */
    public function computeDiscount(float|string $price, int $percent): float
    {
        $price = is_string($price) ? floatval($price) : $price;
        $discountedPrice = $price - ($price * $percent / 100);

        return round($discountedPrice, 2);
    }

    /**
     * Transform a string of more info into an array
     *
     * @param string|null $phrase
     * @return array
     */
    public function grabMoreInfo(?string $phrase): array
    {
        return $phrase ? explode(';', $phrase) : [];
    }
}
