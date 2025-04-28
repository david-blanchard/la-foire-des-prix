<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class RedirectIfAuthenticatedListener
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $user = $request->getSession()->get('user'); // Exemple : récupérer l'utilisateur depuis la session

        if ($user) {
            // Redirige vers une autre page si l'utilisateur est authentifié
            $response = new RedirectResponse($this->router->generate('home'));
            $event->setResponse($response);
        }
    }
}
