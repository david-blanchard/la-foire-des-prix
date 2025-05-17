<?php

namespace App\Service;

use App\Repository\ClothProductRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class CartService extends AbstractSessionObject implements CartServiceInterface
{
    private Session $session;

    public function __construct(
        private readonly ClothProductRepository $productRepository,
        private readonly ProductService $productService,
    ) {
        $this->session = new Session();
    }

    public static function type(): string
    {
        return 'Cart';
    }

    /**
     * Compute the total sum of the cart
     * accordingly to the product prices and quantities.
     *
     * @return array<string, int|float> optimized cart form
     */
    public function computeCart(): array
    {
        $total = 0.0;
        $numberOfProducts = 0;

        $items = $this->items();

        foreach ($items as $productId => $quantity) {
            if (is_array($quantity)) {
                continue;
            }
            $product = $this->productRepository->findById((int) $productId);
            $props = $this->productService->prepareViewFields($product);
            $price = $props['discount'] ?: floatval($props['price']);

            $numberOfProducts += $quantity;
            $total += $price * $quantity;
        }

        return [
            'quantity' => $numberOfProducts,
            'total' => $total,
        ];
    }

    /**
     * Add a product to the cart.
     *
     * @param array<string, mixed> $data
     */
    public function prepare(?array $data = null): void
    {
        $this->reduce($data);
    }

    /**
     * Retrieve the cart state from the given session data.
     *
     * @return array<string, mixed> a state of the cart in session
     */
    public function retrieve(): array
    {
        $result = $this->makeEmptySessionObject();

        $result = $this->session->get('cart') ?? $result;
        if (is_object($result)) {
            $result = self::toArray($result);
        }

        return $result;
    }

    /**
     * Store the cart in session.
     *
     * @param array<mixed> $input data to update the cart with
     */
    public function store(array $input): void
    {
        $sessionData = $this->retrieve();

        $this->reduce($sessionData, $input);
        $sessionCart = $this->makeSessionObject();
        $this->session->set('cart', $sessionCart);
    }

    /**
     * Make the Cart object ready to dipslay.
     *
     * @return array<string, mixed> a simplified form of the Cart
     */
    public function prepareViewFields(?object $data = null): array
    {
        return $this->computeCart();
    }

    /**
     * Optimize the cart so that there's no duplicate key
     * This allows computing the exact sum of a given product
     * accordingly to its actual quantity.
     *
     * @param array<string, mixed>      $sessionData state of the cart in session
     * @param array<string, mixed>|null $input       data to update the cart with
     */
    public function reduce(?array $sessionData, ?array $input = null): void
    {
        if (null === $sessionData) {
            return;
        }

        $sessionContent = $sessionData['content'];

        foreach ($sessionContent as $key => $item) {
            if (is_array($item)) {
                continue;
            }
            $this->add(["$key" => $item]);
        }

        if (null === $input) {
            return;
        }

        $content = 'Cart' === $input['type'] && isset($input['content']) ? $input['content'] : null;
        if (null !== $content) {
            foreach ($content as $item) {
                $this->add(["{$item['productId']}" => $item['quantity']]);
            }
        }
    }

    /**
     * Used to make a default object.
     *
     * @return array<string, mixed> a default object
     */
    public function makeEmptySessionObject(): array
    {
        return [
            'type' => self::type(),
            'content' => [
                [
                    'productId' => 0,
                    'quantity' => 0,
                ],
            ],
        ];
    }
}
