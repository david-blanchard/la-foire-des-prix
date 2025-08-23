<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/front/product')]
#[ApiResource(
    shortName: 'Product',
    description: 'Product management API',
    operations: [
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
