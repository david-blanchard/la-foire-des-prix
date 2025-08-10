<?php

namespace App\Service;

use App\Entity\ProductInterface;

interface ViewServiceInterface
{
    /**
     * @return array<string, mixed>|string
     */
    public function prepareViewFields(?ProductInterface $data = null): array|string;
}
