<?php

namespace App\Session;

use App\Service\CartService;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class SessionObjectFactory implements SessionObjectFactoryInterface
{
    #[Autowire(ContainerInterface::class)]
    public function __construct(
        private readonly ContainerInterface $container
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
