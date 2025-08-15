<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CartService $cartService,
        private readonly ProductService $productService,
    ) {
    }

    /**
     * @return array<mixed>
     */
    public function fetchProductById(?int $productId = null): array
    {
        // Attempt to fetch properties from a cache by ID
        $props = $this->productRepository->getPropertiesFromCacheById($productId);

        if (null === $props) {
            // Fetch attributes and convert them to properties
            $product = $this->productRepository->findById($productId);
            if (null === $product) {
                throw new NotFoundHttpException('Product not found');
            }

            $props = $this->productService->prepareViewFields($product);

            // Store properties in a cache
            $this->productRepository->putPropertiesInCacheById($product->getId(), $props);
        }

        return [$props, $this->cartService->prepareViewFields()];
    }

    /**
     * Fetches a product by its slug and prepares the view fields.
     *
     * @return array<mixed>
     *
     * @throws NotFoundHttpException|\Exception
     */
    public function fetchProductBySlug(string $slug): array
    {
        $props = $this->productRepository->getPropertiesFromCacheBySlug($slug);

        if (null === $props) {
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
        }

        return [$props, $this->cartService->prepareViewFields()];
    }
}
