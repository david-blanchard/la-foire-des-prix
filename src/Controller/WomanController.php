<?php

namespace App\Controller;

use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mode-femme')]
class WomanController extends AbstractController
{
    public function __construct(
        private readonly SearchService $searchService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/', name: 'woman', methods: ['GET'])]
    public function index(?int $productId = null): Response
    {
        [$props, $cartFields] = $this->searchService->fetchProductById($productId);

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
        [$props, $cartFields] = $this->searchService->fetchProductBySlug($slug);

        return $this->render('woman/index.html.twig', [
            ...$props,
            ...$cartFields,
        ]);
    }
}
