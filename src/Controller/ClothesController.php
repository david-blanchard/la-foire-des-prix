<?php

namespace App\Controller;

use App\Repository\ClothProductRepository;
use App\Service\CartService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mode-femme')]
class ClothesController extends AbstractController
{
    public function __construct(
        private readonly ClothProductRepository $productRepository,
        private readonly CartService $cartService,
        private readonly ProductService $productService,
    ) {
    }

    #[Route('/', name: 'woman', methods: ['GET'])]
    public function index(): Response
    {
        // Attempt to fetch properties from a cache by ID
        $props = $this->productRepository->getPropertiesFromCacheById();
        if (null !== $props) {
            return $this->render('woman/index.html.twig', $props);
        }

        // Fetch attributes and convert them to properties
        $product = $this->productRepository->findById();
        $props = $this->productService->prepareViewFields($product);

        $cartFields = $this->cartService->prepareViewFields();

        // Store properties in a cache
        $this->productRepository->putPropertiesInCacheById(null, $props);

        return $this->render('woman/index.html.twig', [
            ...$props,
            ...$cartFields,
        ]);
    }

    #[Route('/{slug}', name: 'product_info', methods: ['GET'])]
    public function show(string $slug): Response
    {
        // Attempt to fetch properties from a cache by slug
        $props = $this->productRepository->getPropertiesFromCacheBySlug($slug);
        if (null !== $props) {
            return $this->render('woman/index.html.twig', $props);
        }

        // Fetch the product by slug
        $product = $this->productRepository->findOneBySlug($slug);

        if (null === $product) {
            throw $this->createNotFoundException('Product not found.');
        }

        // Fetch attributes and convert them to properties
        $product = $this->productRepository->findById($product->getId());
        $props = $this->productService->prepareViewFields($product);

        // Store properties in a cache
        $this->productRepository->putPropertiesInCacheBySlug($slug, $props);

        $cartFields = $this->cartService->prepareViewFields();

        return $this->render('woman/index.html.twig', [
            ...$props,
            ...$cartFields,
        ]);
    }
}
