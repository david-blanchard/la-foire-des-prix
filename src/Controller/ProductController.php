<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/front/product')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly SearchService $searchService,
    )
    {
    }


    /**
     * @throws \Exception
     */
    #[Route('/{id}/retrieve',
        name: 'api_product_retrieve_id',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function retrieveId(?int $id = null): JsonResponse
    {
//        dd(["method" => __METHOD__, "productId" => $productId]);
        [$props, $cartFields] = $this->searchService->fetchProductById($id);

        return new JsonResponse([
            'status' => 'success',
            'data' => [
                'product' => $props,
                'cartFields' => $cartFields,
            ],
        ]);
    }


    #[Route('/best/retrieve', name: 'api_product_best', methods: ['GET'])]
    public function retrieveBest(): Response
    {
        [$props, $cartFields] = $this->searchService->fetchProductById(null);

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
    #[Route('/{slug}/retrieve', name: 'api_product_retrieve_slug', methods: ['GET'])]
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
