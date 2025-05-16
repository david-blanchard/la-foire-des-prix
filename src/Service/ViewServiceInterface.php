<?php

namespace App\Service;

interface ViewServiceInterface
{
    /**
     * @return array<string, mixed>
     */
    public function prepareViewFields(?object $data = null): array;
}
