<?php

namespace App\Service;

use App\Dto\CartOutput;

interface CartServiceInterface extends ViewServiceInterface, SessionObjectInterface
{
    /**
     * Compute the total sum of the cart
     * accordingly to the product prices and quantities.
     *
     * @return CartOutput optimized cart form
     */
    public function computeCart(): CartOutput;
}
