<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class CartStoreInput
{
    #[Groups(['cart:write', 'cart:read'])]
    public ?string $type = null;

    /**
     * @var CartStoreInputContent[]
     */
    #[Groups(['cart:write', 'cart:read'])]
    public array $content = [];
}
