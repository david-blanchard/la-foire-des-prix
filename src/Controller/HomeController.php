<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(): Response
    {
        // Attempt to fetch properties from cache by ID
        $props = $this->productRepository->getPropertiesFromCacheById(-1);
        if ($props !== null) {
            return $this->render('home/index.html.twig', $props);
        }

        // Fetch attributes and convert them to properties
        $attr = $this->productRepository->getAttributesByProductId();
        $props = $this->productRepository->attributesToProperties($attr);

        // Store properties in cache
        $this->productRepository->putPropertiesInCacheById(-1, $props);

        return $this->render('home/index.html.twig', $props);
    }

    /**
     * @Route("/product/{slug}", name="product_show", methods={"GET"})
     */
    public function show(string $slug): Response
    {
        // Attempt to fetch properties from cache by slug
        $props = $this->productRepository->getPropertiesFromCacheBySlug($slug);
        if ($props !== null) {
            return $this->render('home/index.html.twig', $props);
        }

        // Fetch the product by slug
        $product = $this->productRepository->findOneBySlug($slug);

        if ($product === null) {
            throw $this->createNotFoundException('Product not found.');
        }

        // Fetch attributes and convert them to properties
        $attr = $product->getAttributes();
        $props = $this->productRepository->attributesToProperties($attr);

        // Store properties in cache
        $this->productRepository->putPropertiesInCacheBySlug($slug, $props);

        return $this->render('home/index.html.twig', $props);
    }
}