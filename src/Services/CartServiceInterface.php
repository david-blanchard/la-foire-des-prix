<?php

namespace App\Services;

use App\Session\SessionObjectInterface;

interface CartServiceInterface extends SessionObjectInterface
{
    public function computeCart() : array;

}
