<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use App\Controller\CartController;
use App\Dto\CartOutput;
use App\Dto\CartRetrieveInput;
use App\Dto\CartStoreInput;

#[ApiResource(
    shortName: 'Cart',
    description: 'Cart management API',
    operations: [
        new \ApiPlatform\Metadata\Post(
            uriTemplate: '/cart/retrieve',
            status: 200,
            controller: CartController::class . '::retrieve',

        ),
        new \ApiPlatform\Metadata\Post(
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
