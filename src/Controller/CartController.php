<?php

namespace App\Controller;

use App\Service\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
final class CartController extends AbstractController
{
    public function __construct(
        private readonly CartServiceInterface $cartService,
    ) {
    }

    #[Route('/retrieve', name: 'cart_retrieve', methods: ['POST'] )]
    public function retrieve(): JsonResponse
    {
        $sessionData = $this->cartService->retrieve();
        $this->cartService->prepare($sessionData);
        $data = $this->cartService->prepareViewFields();

        return $this->json($data);
    }

    #[Route('/store', name: 'cart_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $input = $request->request->all();
        $this->cartService->store($input);
        $data = $this->cartService->prepareViewFields();

        return $this->json($data);
    }
}
