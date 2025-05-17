<?php

namespace App\Service;

interface CartServiceInterface extends ViewServiceInterface, SessionObjectInterface
{
    /**
     * Compute the total sum of the cart
     * accordingly to the product prices and quantities.
     *
     * @return array<string, int|float> optimized cart form
     */
    public function computeCart(): array;
}
