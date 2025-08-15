<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CartService       $cartService,
        private readonly ProductService    $productService,
    ) {
    }

    public function fetchProductById(?int $productId = null): ?array
    {
        // Fetch attributes and convert them to properties
        $product = $this->productRepository->findById($productId);
        $props = $this->productService->prepareViewFields($product);

        return [$props, $this->cartService->prepareViewFields()];
    }


    /**
     * Fetches a product by its slug and prepares the view fields.
     *
     * @param string $slug
     *
     * @return array<string[], array>
     *
     * @throws NotFoundHttpException|\Exception
     */
    public function fetchProductBySlug(string $slug): array {
        // Fetch the product by slug
        $product = $this->productRepository->findOneBySlug($slug);

        if (null === $product) {
            throw new NotFoundHttpException('Product not found');
        }

        // Fetch attributes and convert them to properties
        $product = $this->productRepository->findById($product->getId());
        $props = $this->productService->prepareViewFields($product);

        // Store properties in a cache
        $this->productRepository->putPropertiesInCacheBySlug($slug, $props);

        return [$props, $this->cartService->prepareViewFields()];
    }
}
