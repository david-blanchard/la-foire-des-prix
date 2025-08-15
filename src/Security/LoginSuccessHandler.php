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
use Symfony\Component\Security\Core\User\UserInterface;
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
        /* @var UserInterface $tokenUser */
        $tokenUser = $token->getUser();

        if($tokenUser === null) {
            return new RedirectResponse($this->router->generate('home'));
        }


        $jwt = $this->jwtManager->create($tokenUser);
        $user = $token->getUser();

        if (in_array(User::ADMIN_ROLE, $user?->getRoles() ?? [], true)) {
            $response = new RedirectResponse($this->router->generate('admin_dashboard'));
        } else {
            $response = new RedirectResponse($this->router->generate('home'));
        }

        $cookie = new Cookie('jwt', $jwt, 0, '/', null, false, false);
        $response->headers->setCookie($cookie);

        return $response;
    }
}
