<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mode-femme')]
class WomanController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CartService       $cartService,
        private readonly ProductService    $productService,
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

        // Fetch attributes and convert them to properties
        $product = $this->productRepository->findById();
        $props = $this->productService->prepareViewFields($product);

        $cartFields = $this->cartService->prepareViewFields();

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
        $cartFields = HomeController::fetchProductBySlug(
            $this->productRepository,
            $this->cartService,
            $this->productService,
            $slug
        );

        return $this->render('woman/index.html.twig', [
            ...$props,
            ...$cartFields,
        ]);
    }
}
