<?php

namespace App\Twig\Runtime;

use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Extension\RuntimeExtensionInterface;

class IsAdminRuntime implements RuntimeExtensionInterface
{
    public function __construct(
    ) {
    }

    public function userIsAdmin(): bool
    {
        $session = new Session();

        $roles = $session->get('user')?->getRoles();
        if (is_array($roles) && isset($roles['ROLE_ADMIN'])) {
            return true;
        }

        return false;
    }
}
