<?php

namespace App\Repositories;

use App\Models\Products;
use App\Utils\MiscUtils;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductsRepository implements ProductsRepositoryInterface
{

    public function __construct(
        private readonly BrandsRepository $brandsRepository,
        private readonly ImagesRepository $imagesRepository,
    ) {
    }

    public function getAll(): array
    {
        return Products::all()->toArray();
    }

    public function getById($id): ?Products
    {
        $products = Products::where('id', $id)->get();
        if(count($products)) {
            return $products->first();
        }

        return null;
    }

    /**
     * Retrieve the values of a given product
     *
     * @param integer $productId
     * @return array
     */
    function getAttributesByProductId(?int $productId = null): array
    {
        $result = [];
        if($productId === null) {
            $result = DB::table('products')->first();
            $result = MiscUtils::toArray($result);
        } else {
            $result = Products::where('id', $productId)->get()->first()->getAttributes();
        }

        return $result;
    }

    /**
     * Transform ProductInfo attributes in properties usable in views
     *
     * @param array $props
     * @return array
     */
    public function attributesToProperties(array $props): array
    {
        $discount = $this->getProductDiscountById($props['id']);
        $props['brand'] = $this->brandsRepository->getBrandNameById($props['brand']);
        $props['discountRate'] = $discount;
        $props['discount'] = $this->computeDiscount($props['price'], $discount);

        $props['featuresCaption'] = 'Information complémentaires';
        $props['features'] = $this->grabMoreInfo($props['more_infos']);

        $images = $this->imagesRepository->getImagesByProductId($props['id']);
        $props['images'] = $images;

        return $props;
    }

    /**
     * Used to split the 'MoreInfo' field into an array of strings
     *
     * @param string $phrase
     * @return array
     */
    public function grabMoreInfo(?string $phrase): array
    {
        $result = [];

        if($phrase === null) {
            return $result;
        }

        $result = explode(';', $phrase);

        return $result;
    }

    /**
     * Retrieve the discount rate of the campain the product is associated with
     *
     * @param integer $productId
     * @return integer
     */
    public function getProductDiscountById(int $productId): int
    {
        $result = 0.0;

        $today = date('Y-m-d');

        $discounts = DB::table('campaigns')
        ->join('campaign_products', function ($join) use ($today, $productId) {
            $join->on('campaigns.id', '=', 'campaign_products.campaign')
                 ->where('campaign_products.product', '=', $productId)
                 ->whereRaw('? between `campaigns`.`start` and `campaigns`.`end`', ["$today"]);
        })->get();

        $result = $discounts = count($discounts->toArray()) ? $discounts[0]->discount : 0;

        return $result;
    }

    /**
     * Get the discount price for the given amount and percent rate
     *
     * @param float|string $price
     * @param int $percent
     * @return float
     */
    public function computeDiscount(float|string $price, int $percent): float
    {
        $result = 0.00;

        if(is_string($price)) {
            $price = floatval($price);
        }

        $price = $price - $price * $percent / 100;
        $result = ceil(round($price, 2) * 100) / 100;

        return $result;
    }

    /**
     * Remove the product page properties from the cache by Products object
     *
     * @param Products $product
     * @return void
     */
    public function deletePropertiesFromCache(Products $product) : void
    {
        self::deletePropertiesFromCacheById($product->id);
    }

    /**
     * Remove the product page properties from the cache by ID
     *
     * @param integer $productId ID of the product
     * @return void
     */
    public function deletePropertiesFromCacheById(int $productId) : void
    {
        if(Cache::has("product$productId")) {
            Cache::pull("product$productId");
        }
    }

    /**
     * Retrieve the product page properties from the cache by slug
     *
     * @param string $slug Free form of the product name
     * @return array|null $properties Values to be set in product page view
     */
    public function getPropertiesFromCacheBySlug(string $slug): ?array
    {
        $result = null;

        $productId = Cache::has("product$slug") ? Cache::get("product$slug") : null;
        if($productId !== null) {
            $result = $this->getPropertiesFromCacheById($productId);
        }

        return $result;
    }

    /**
     * Store the product page properties in cache by slug
     *
     * @param string $slug Free form of the product name
     * @param array $properties Values to be set in product page view
     * @return void
     */
    public function putPropertiesInCacheBySlug(string $slug, array $properties): void
    {
        if(!Cache::has("product$slug"))
        {
            $id = $properties['id'];
            Cache::put("product$slug", $id);
            $this->putPropertiesInCacheById($id, $properties);
        }
    }

    /**
     * Retrieve the product page properties from the cache by ID
     *
     * @param integer $id ID of the product
     * @return array|null Values to be set in product page view
     */
    public function getPropertiesFromCacheById(int $id): ?array
    {
        $product = Cache::has("product$id") ? Cache::get("product$id") : null;

        return $product;
    }

    /**
     * Store the product page properties in cache by ID
     *
     * @param integer $id ID of the product
     * @param array $properties Values to be set in product page view
     * @return void
     */
    public function putPropertiesInCacheById(int $id, array $properties): void
    {
        if(!Cache::has("product$id"))
        {
            Cache::put("product$id", $properties);
        }
    }

}
