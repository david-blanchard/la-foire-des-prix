<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\ProductInput;
use App\Dto\ProductViewProperties;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[ApiResource(
    shortName: 'Product',
    description: 'Product management API',
    operations: [],
    controller: ProductController::class . '::retrieve',
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']],
    input: ProductInput::class,
    output: ProductViewProperties::class,
    security: "is_granted('ROLE_USER')",
    provider: null,
    processor: null,
)]
class ProductController extends AbstractController
{
    #[Route('/product')]
    public function __construct(
        private readonly SearchService $searchService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/{int: productId}/retrieve',
        name: 'app_product_index',
        options: ['requirements' => ['int' => '\d+'],],
        methods: ['GET']
    )]
    public function retrieve(?int $productId = null): JsonResponse
    {
        [$props, $cartFields] = $this->searchService->fetchProductById($productId);
        return new JsonResponse([
            'status' => 'success',
            'data' => [
                'product' => $props,
                'cartFields' => $cartFields,
            ],
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/{string: slug}/retrieve', name: 'app_product_slug', methods: ['GET'])]
    public function retrieveBySlug(string $slug): Response
    {
        [$props, $cartFields] = $this->searchService->fetchProductBySlug($slug);
        return new JsonResponse([
            'status' => 'success',
            'data' => [
                'product' => $props,
                'cartFields' => $cartFields,
            ],
        ]);
    }
}
