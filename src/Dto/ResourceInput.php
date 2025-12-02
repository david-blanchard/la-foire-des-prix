<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class ResourceInput
{
    #[Groups(['resource:read'])]
    public ?string $type = null;
}
