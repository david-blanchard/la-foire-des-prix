<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiProperty;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'api_cart_')]
class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
    )
    {
    }

    #[ApiProperty(
        description: 'Retrieve the current cart from the session',
        security: "is_granted('ROLE_USER')",
        uriTemplate: '/retrieve',
    )]
    public function retrieve(): JsonResponse
    {
        $sessionData = $this->cartService->retrieve();
        $this->cartService->prepare($sessionData);
        $computedCart = $this->cartService->prepareViewFields();

        return new JsonResponse($computedCart);
    }

    #[ApiProperty(
        description: 'Store the current cart in the session',
        security: "is_granted('ROLE_USER')",
        uriTemplate: '/store',
    )]
    public function store(Request $request): JsonResponse
    {
        $json = $request->getContent();
        $input = (array)json_decode($json, true);
        $this->cartService->store($input);
        $computedCart = $this->cartService->prepareViewFields();

        return new JsonResponse($computedCart);
    }

    #[ApiProperty(
        description: 'Generate a new cart identifier',
        security: "is_granted('ROLE_USER')",
        uriTemplate: '/id',
    )]
    #[Route('/id', name: 'generate_id', methods: ['POST'])]
    public function generateCartId(): JsonResponse
    {
        $cartId = $this->cartService->getCartIdentifier();

        return $this->json([
            'success' => true,
            'cartId' => $cartId,
        ]);
    }

    #[ApiProperty(
        description: 'Clear the current cart in the session',
        security: "is_granted('ROLE_USER')",
        uriTemplate: '/clear',
    )]
    #[Route('/clear', name: 'clear', methods: ['DELETE'])]
    public function clear(): void
    {
        $this->cartService->destroy();
    }

}
