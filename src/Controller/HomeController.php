<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return new RedirectResponse('/mode-femme/');
    }

    /**
     * Fetches a product by its slug and prepares the view fields.
     *
     * @param ProductRepository $productRepository
     * @param CartService      $cartService
     * @param ProductService    $productService
     * @param string            $slug
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public static function fetchProductBySlug(
        ProductRepository $productRepository,
        CartService       $cartService,
        ProductService    $productService,
        string            $slug
    ): array {
        // Fetch the product by slug
        $product = $productRepository->findOneBySlug($slug);

        if (null === $product) {
            throw new NotFoundHttpException('Product not found');
        }

        // Fetch attributes and convert them to properties
        $product = $productRepository->findById($product->getId());
        $props = $productService->prepareViewFields($product);

        // Store properties in a cache
        $productRepository->putPropertiesInCacheBySlug($slug, $props);

        return $cartService->prepareViewFields();
    }
}
