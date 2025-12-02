<?php

// src/Dto/CartItemInput.php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class ProductInput
{
    #[Groups(['product:write', 'product:read'])]
    public ?int $productId = null;
}
