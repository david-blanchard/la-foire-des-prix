<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recherche')]
class SearchController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CartService       $cartService,
        private readonly ProductService    $productService,
    ) {
    }

    #[Route('/{slug}', name: 'search', methods: ['GET'])]
    public function index(string $slug): Response
    {
        try {
            // Attempt to fetch properties from a cache by slug
            $props = $this->productRepository->getPropertiesFromCacheBySlug($slug);
            if (null !== $props) {
                return $this->render('search/index.html.twig', $props);
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

            return $this->render('search/index.html.twig', [
                ...$props,
                ...$cartFields,
            ]);
        } catch (NotFoundHttpException $notFoundHttpException) {
            // Handle the exception if needed
            $cartFields = $this->cartService->prepareViewFields();

            return $this->render('errors/404.html.twig', [
                ...$cartFields,
            ]);
        } catch (\Throwable $throwable) {
            // Handle the exception if needed
            $cartFields = $this->cartService->prepareViewFields();

            return $this->render('errors/500.html.twig', [
                ...$cartFields,
                'error' => $throwable->getMessage(),
            ]);
        }
    }
}
