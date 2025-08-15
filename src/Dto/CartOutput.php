<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\Groups;

class CartOutput
{
    #[Groups(['cart:read'])]
    public ?int $quantity = null;

    #[Groups(['cart:read'])]
    public ?float $total = null;
}
