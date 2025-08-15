<?php

namespace App\Service;

use App\Dto\ProductViewProperties;
use App\Entity\ProductInterface;
use App\Repository\CampaignProductsRepository;
use App\Repository\ProductImageRepository;

readonly class ProductService implements ViewServiceInterface
{
    public function __construct(
        private ProductImageRepository $imagesRepository,
        private CampaignProductsRepository $productCampaignRepository,
    ) {
    }

    /**
     * Transform ProductInfo attributes in properties usable in views.
     *
     * @return array<string, mixed>|string Array of properties
     */
    public function prepareViewFields(?ProductInterface $data = null): array|string
    {
        $discount = $this->productCampaignRepository->getProductDiscountById($data?->getId());
        $props = new ProductViewProperties();
        if (null !== $data) {
            $images = $this->imagesRepository->findByProductId((int) $data?->getId());

            $props->setId($data?->getId())
                ->setName($data?->getName())
                ->setDescription($data?->getDescription())
                ->setMoreInfo($data?->getMoreInfo())
                ->setPrice($data?->getPrice())
                ->setBrand($data?->getBrand()?->getName())
                ->setDiscountRate($discount)
                ->setDiscount($this->computeDiscount((float) $data?->getPrice(), $discount))
                ->setFeaturesCaption('Information complémentaires')
                ->setFeatures($this->grabMoreInfo($data?->getMoreInfo()))
                ->setImages($images);
        }

        return $props->toArray();
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
