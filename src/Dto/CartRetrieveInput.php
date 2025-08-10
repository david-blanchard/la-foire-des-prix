<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class CartRetrieveInput
{
    #[Groups(['cart:write', 'cart:read'])]
    public ?string $type = null;
}
