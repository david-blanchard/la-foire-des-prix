<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\ProductService;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mode-femme')]
class WomanController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly SearchService     $searchService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/', name: 'woman', methods: ['GET'])]
    public function index(): Response
    {
        // Attempt to fetch properties from a cache by ID
        $props = $this->productRepository->getPropertiesFromCacheById(-1);
        if (null !== $props) {
            return $this->render('woman/index.html.twig', $props);
        }

        [$props, $cartFields] = $this->searchService->fetchProductById();

        // Store properties in a cache
        $this->productRepository->putPropertiesInCacheById(-1, $props);

        return $this->render('woman/index.html.twig', [
            ...$props,
            ...$cartFields,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/{slug}', name: 'product_info', methods: ['GET'])]
    public function show(string $slug): Response
    {
        // Attempt to fetch properties from a cache by slug
        $props = $this->productRepository->getPropertiesFromCacheBySlug($slug);
        if (null !== $props) {
            return $this->render('woman/index.html.twig', $props);
        }

        // Fetch the product by slug
        [$props, $cartFields] = $this->searchService->fetchProductBySlug($slug);

        $this->productRepository->putPropertiesInCacheById($props['id'] ?? null, $props);

        return $this->render('woman/index.html.twig', [
            ...$props,
            ...$cartFields,
        ]);
    }
}
