<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\CartController;
use App\Dto\CartOutput;
use App\Dto\CartStoreInput;
use App\Dto\ResourceInput;

#[ApiResource(
    shortName: 'Cart',
    description: 'Cart management API',
    operations: [
        new Post(
            uriTemplate: '/cart/retrieve',
            status: 200,
            controller: CartController::class . '::retrieve',
            description: 'Retrieve the current cart from the session',
            security: "is_granted('ROLE_USER')",
            input: ResourceInput::class,
            output: CartOutput::class,
            name: 'cart_retrieve',
        ),
        new Post(
            uriTemplate: '/cart/store',
            status: 200,
            controller: CartController::class . '::store',
            description: 'Send the current cart addition to the session',
            security: "is_granted('ROLE_USER')",
            input: CartStoreInput::class,
            output: CartOutput::class,
            name: 'cart_store',
        ),
    ],
    normalizationContext: ['groups' => ['cart:read']],
    denormalizationContext: ['groups' => ['cart:write']],
    security: "is_granted('ROLE_USER')",
    provider: null,
    processor: null,
)]
class CartResource
{
}
