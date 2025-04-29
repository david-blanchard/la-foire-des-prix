<?php

namespace App\Session;

use App\Service\CartService;
use Psr\Container\ContainerInterface;

class SessionObjectFactory implements SessionObjectFactoryInterface
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function create(array $data): ?SessionObjectInterface
    {
        $result = null;

        if (!isset($data['type'])) {
            return $result;
        }

        if ($data['type'] === CartService::type()) {
            $result = $this->container->get(CartService::class);
        }

        return $result;
    }
}
