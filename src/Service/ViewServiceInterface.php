<?php

namespace App\Service;

use App\Entity\ProductInterface;

interface ViewServiceInterface
{
    /**
     * @return array<mixed>
     */
    public function prepareViewFields(?ProductInterface $data = null): array;
}
