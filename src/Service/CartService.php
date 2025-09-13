<?php

namespace App\Service;

use App\Dto\CartOutput;
use App\Dto\CartStoreInput;
use App\Dto\CartStoreInputContent;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CartService extends AbstractSessionObject implements CartServiceInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductService $productService,
        private readonly SerializerInterface $serializer,
        private readonly CacheInterface $cache,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * Compute the total sum of the cart
     * accordingly to the product prices and quantities.
     *
     * @return CartOutput optimized cart form
     */
    public function computeCart(): CartOutput
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

        $catOutput = new CartOutput();
        $catOutput->quantity = $numberOfProducts;
        $catOutput->total = $total;
        $catOutput->cartId = $this->getCartIdentifier();

        return $catOutput;
    }

    /**
     * Make the Cart object ready to display.
     *
     * @return array<string, mixed>
     *
     * @throws \Exception
     */
    public function prepareViewFields(?object $data = null): array
    {
        $computedCart = $this->computeCart();
        $json = $this->serializer->serialize($computedCart, 'json', ['groups' => ['cart:read']]);

        return json_decode($json, true);
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
     * Optimize the cart so that there's no duplicate key
     * This allows computing the exact sum of a given product
     * accordingly to its actual quantity.
     *
     * @param array<string, mixed>      $sessionData state of the cart in cache
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
     * Store the cart in cache avec identifiant unique.
     *
     * @param array<mixed> $input data to update the cart with
     */
    public function store(?array $input = null): void
    {
        $sessionData = $this->retrieve();

        $this->reduce($sessionData, $input);
        $sessionCart = $this->makeSessionObject();

        $cartKey = $this->getCartIdentifier();

        $this->cache->delete($cartKey);

        $this->cache->get($cartKey, function (ItemInterface $item) use ($sessionCart): array {
            $item->expiresAfter(3600); // 1 heure d'expiration

            return $sessionCart;
        });
    }

    /**
     * Retrieve the cart state from the given cache data.
     *
     * @return array<string, mixed> a state of the cart in cache
     */
    public function retrieve(): array
    {
        $cartKey = $this->getCartIdentifier();

        return $this->cache->get($cartKey, function (): array {
            return $this->makeEmptySessionObject();
        });
    }

    /**
     * Used to make a default object.
     *
     * @return array<string, mixed> a default object
     */
    public function makeEmptySessionObject(): array
    {
        $cartInput = new CartStoreInput();
        $cartInput->type = self::type();
        $cartInput->content = [];
        $cartItem = new CartStoreInputContent();
        $cartItem->productId = 0;
        $cartItem->quantity = 0;
        $cartInput->content[] = $cartItem;

        $json = $this->serializer->serialize($cartInput, 'json', ['groups' => ['cart:write']]);

        return json_decode($json, true);
    }

    public static function type(): string
    {
        return 'Cart';
    }

    public function destroy(): void
    {
        $emptyCart = [
            'type' => 'Cart',
            'content' => []
        ];

        $this->store($emptyCart);

        $cartKey = $this->getCartIdentifier();
        $this->cache->delete($cartKey);
    }

    private function getCartIdFromRequest(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request->headers->get('X-Cart-ID');
    }

    /**
     * Generate a unique cart identifier based on user or session.
     */
    public function getCartIdentifier(): string
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if ($user) {
            return 'cart_user_' . $user->getId();
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request) {
            $cartId = $request->headers->get('X-Cart-ID');

            if ($cartId) {
                return 'cart_guest_' . $cartId;
            }

            $ip = $request->getClientIp();
            $userAgent = $request->headers->get('User-Agent', '');

            return 'cart_temp_' . md5($ip . $userAgent);
        }

        return 'cart_default_' . uniqid();
    }
}
