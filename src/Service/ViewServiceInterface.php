<?php

namespace App\Service;

interface ViewServiceInterface
{
    public function prepareViewFields(?object $data = null): array;

}
