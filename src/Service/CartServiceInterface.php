<?php

namespace App\Service;

use App\Session\SessionObjectInterface;

interface CartServiceInterface extends SessionObjectInterface
{
    public function computeCart() : array;

}
