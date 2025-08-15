<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recherche')]
class SearchController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly SearchService $searchService,
    ) {
    }

    #[Route('/{slug}', name: 'search', methods: ['GET'])]
    public function index(string $slug): Response
    {
        try {
            [$props, $cartFields] = $this->searchService->fetchProductBySlug($slug);

            return $this->render('search/index.html.twig', [
                ...$props,
                ...$cartFields,
            ]);
        } catch (NotFoundHttpException $notFoundHttpException) {
            return $this->render('errors/404.html.twig', $this->cartService->prepareViewFields());
        } catch (\Exception $throwable) {
            $cartFields = $this->cartService->prepareViewFields();

            return $this->render('errors/500.html.twig', [
                ...$cartFields,
                'error' => $throwable->getMessage(),
            ]);
        }
    }
}
