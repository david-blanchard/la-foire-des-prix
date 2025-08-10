<?php

namespace App\Security;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {
    }

    /**
     * @throws JWTEncodeFailureException
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $jwt = $this->jwtManager->create($token->getUser());
        $user = $token->getUser();

        if ($request->isXmlHttpRequest() || str_contains($request->getAcceptableContentTypes()[0] ?? '', 'json')) {
            $response = new JsonResponse(['success' => true]);
        } elseif (in_array(User::ADMIN_ROLE, $user?->getRoles() ?? [], true)) {
            $response = new RedirectResponse($this->router->generate('admin_dashboard'));
        } else {
            $response = new RedirectResponse($this->router->generate('home'));
        }

        $cookie = new Cookie('jwt', $jwt, 0, '/', null, false, false);
        $response->headers->setCookie($cookie);

        return $response;
    }

}
