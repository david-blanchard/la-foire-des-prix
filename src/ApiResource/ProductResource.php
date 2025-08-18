<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\ProductController;
use App\Dto\ProductInput;
use App\Dto\ProductViewProperties;

#[ApiResource(
    shortName: 'Product',
    description: 'Product management API',
    operations: [
        new Post(
            uriTemplate: '/product/retrieve',
            status: 200,
            controller: ProductController::class . '::retrieve',
            description: 'Retrieve the product from the session',
            security: "is_granted('ROLE_USER')",
            input: ProductInput::class,
            output: ProductViewProperties::class,
            name: 'cart_retrieve',
        ),
    ],
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']],
    security: "is_granted('ROLE_USER')",
    provider: null,
    processor: null,
)]
class ProductResource
{

}
