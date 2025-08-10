<?php
// src/Dto/CartItemInput.php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class CartStoreInputContent
{
    #[Groups(['cart:write' , 'cart:read'])]
    public ?int $productId = null;

    #[Groups(['cart:write' , 'cart:read'])]
    public ?int $quantity = 0;
}
