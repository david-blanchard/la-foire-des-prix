<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\IsAdminRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IsAdminExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('isAdmin', [IsAdminRuntime::class, 'userIsAdmin']),
        ];
    }
}
