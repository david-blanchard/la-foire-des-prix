<?php

namespace App\Service;

use App\Entity\ProductInterface;

interface ViewServiceInterface
{
    /**
     * @return array<string, mixed>
     */
    public function prepareViewFields(?ProductInterface $data = null): array;
}
