<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiProperty;
use App\Service\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    public function __construct(
        private readonly CartServiceInterface $cartProvider,
    )
    {
    }

    #[ApiProperty(
        description: 'Retrieve the current cart from the session',
        security: "is_granted('ROLE_USER')",
        uriTemplate: '/cart/retrieve',
    )]
    public function retrieve(): JsonResponse
    {
        $sessionData = $this->cartProvider->retrieve();
        $this->cartProvider->prepare($sessionData);
        $computedCart = $this->cartProvider->prepareViewFields();

        return new JsonResponse($computedCart);
    }

    #[ApiProperty(
        description: 'Store the current cart in the session',
        security: "is_granted('ROLE_USER')",
        uriTemplate: '/cart/retrieve',
    )]
    public function store(Request $request): JsonResponse
    {
        $json = $request->getContent();
        $input = (array)json_decode($json, true);
        $this->cartProvider->store($input);
        $computedCart = $this->cartProvider->prepareViewFields();

        return new JsonResponse($computedCart);
    }
}
