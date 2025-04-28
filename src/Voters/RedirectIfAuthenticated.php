<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AuthenticatedVoter extends Voter
{
    private const IS_AUTHENTICATED = 'IS_AUTHENTICATED';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Vérifie si l'attribut correspond à ce que le Voter doit gérer
        return $attribute === self::IS_AUTHENTICATED;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Vérifie si l'utilisateur est authentifié
        return $user !== null;
    }
}
