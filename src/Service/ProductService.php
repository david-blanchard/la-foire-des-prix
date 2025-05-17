<?php

namespace App\Service;

use App\Entity\ProductInterface;
use App\Repository\ClothProductRepository;
use App\Repository\ImageRepository;

readonly class ProductService implements ViewServiceInterface
{
    public function __construct(
        private ClothProductRepository $productRepository,
        private ImageRepository $imagesRepository,
    ) {
    }

    /**
     * Transform ProductInfo attributes in properties usable in views.
     *
     * @return array<string, mixed> Array of properties
     */
    public function prepareViewFields(?ProductInterface $data = null): array
    {
        //        if (null === $data) {
        //            return [];
        //        }

        $discount = $this->productRepository->getProductDiscountById($data?->getId());
        $props = [];
        $props['name'] = $data?->getName();
        $props['id'] = $data?->getId();
        $props['description'] = $data?->getDescription();
        $props['moreInfo'] = $data?->getMoreInfo();
        $props['price'] = $data?->getPrice();
        $props['brand'] = $data?->getBrand()?->getName();
        $props['discountRate'] = $discount;
        $props['discount'] = $this->computeDiscount((float) $data?->getPrice(), $discount);

        $props['featuresCaption'] = 'Information complémentaires';
        $props['features'] = $this->grabMoreInfo($data?->getMoreInfo());

        $images = $this->imagesRepository->findByProductId((int) $data?->getId());
        $props['images'] = $images;

        return $props;
    }

    /**
     * Compute the discounted price of a product.
     *
     * @param float|string $price   Original price
     * @param int          $percent Discount percentage
     *
     * @return float Discounted price
     */
    public function computeDiscount(float|string $price, int $percent): float
    {
        $price = is_string($price) ? floatval($price) : $price;
        $discountedPrice = $price - ($price * $percent / 100);

        return round($discountedPrice, 2);
    }

    /**
     * Transform a string of more info into an array.
     *
     * @param string|null $phrase String of more info
     *
     * @return array<string> Array of more info
     */
    public function grabMoreInfo(?string $phrase): array
    {
        return $phrase ? explode(';', $phrase) : [];
    }
}
