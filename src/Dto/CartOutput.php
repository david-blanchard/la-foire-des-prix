<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\Groups;

class CartOutput
{
    #[Groups(['cart:read'])]
    public int $quantity = 0;

    #[Groups(['cart:read'])]
    public float $total = 0.0;

    #[Groups(['cart:read'])]
    public string $cartId = '';
}
