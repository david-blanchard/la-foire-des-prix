<?php

namespace App\Service;

use App\Session\SessionObjectInterface;

interface CartServiceInterface extends ViewServiceInterface, SessionObjectInterface
{
    public function computeCart() : array;

}
