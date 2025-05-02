<?php

namespace App\Service;

interface CartServiceInterface extends ViewServiceInterface, SessionObjectInterface
{
    public function computeCart() : array;

}
