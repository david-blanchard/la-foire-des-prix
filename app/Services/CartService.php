<?php

namespace App\Services;

use App\Repositories\ProductsRepository;
use App\Session\AbstractSessionObject;

class CartService extends AbstractSessionObject implements CartServiceInterface
{
    public function __construct(
        private readonly ProductsRepository $productsRepository
    ) {
    }

    public static function type(): string
    {
        return 'Cart';
    }

    /**
     * Compute the total sum of the cart
     * accordingly to the product prices and quantities
     *
     * @return array optimized cart form
     */
    public function computeCart(): array
    {
        $result = [];

        $total = 0.0;
        $numberOfProducts = 0;

        $items = $this->items();

        foreach ($items as $productId => $quantity) {
            if (is_array($quantity)) {
                continue;
            }
            $attr = $this->productsRepository->getAttributesByProductId($productId);
            $props = $this->productsRepository->attributesToProperties($attr);
            $price = $props['discount'] ?: floatval($props['price']);

            $numberOfProducts += $quantity;
            $total += $price * $quantity;
        }

        $result = [
            "quantity" => $numberOfProducts,
            "total" => $total,
        ];

        return $result;
    }

    public function prepare(?array $data = null): void
    {
        $this->reduce($data);
    }

    /**
     * Retrieve the cart state from the given session data
     *
     * @return array a state of the cart in session
     */
    public function retrieve(): array
    {
        $result = $this->makeEmptySessionObject();

        $result = session('cart') ?: $result;
        if (is_object($result)) {
            $result = self::toArray($result);
        }

        return $result;
    }

    /**
     * Store the cart in session
     *
     * @return array an optimized session object
     */
    public function store(array $input): array
    {
        $sessioncData = $this->retrieve();

        $this->reduce($sessioncData, $input);
        $sessionCart = $this->makeSessionObject();
        session(['cart' => $sessionCart]);

        return $sessionCart;
    }

    /**
     * Make the Cart object ready to dipslay
     *
     * @return array a simplified form of the Cart
     */
    public function prepareViewFields(): array
    {
        return $this->computeCart();
    }

    /**
     * Optimize the cart so that there's no duplicate key
     * This allows the compute the exact sum of a given product
     * accordingly to its actual quantity
     *
     * @param array $sessioncData state of the cart in session
     * @param array $input data to update the cart with
     * @return \App\Session\Cart Cart object
     */
    public function reduce(array $sessioncData, ?array $input = null): void
    {

        $sessionContent = $sessioncData['content'];

        foreach ($sessionContent as $key => $item) {
            if (is_array($item)) {
                continue;
            }
            $this->add(["$key" => $item]);
        }

        if ($input === null) {
            return;
        }

        $content = $input["type"] === "Cart" && isset($input["content"]) ?  $input["content"] : null;
        if ($content !== null) {

            foreach ($content as $item) {
                $this->add(["{$item['productId']}" => $item['quantity']]);
            }
        }
    }

    /**
     * Used to make a default object
     *
     * @return array
     */
    public function makeEmptySessionObject(): array
    {
        return [
            'type' => 'Cart',
            'content' => [
                [
                    'productId' => 0,
                    'quantity' => 0,
                ]
            ]
        ];
    }

}
