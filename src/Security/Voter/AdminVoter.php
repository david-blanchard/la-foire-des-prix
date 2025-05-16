<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class AdminVoter.
 *
 * @extends Voter<string, User>
 */
class AdminVoter extends Voter
{
    private const string ADMIN_ROLE = 'ROLE_ADMIN';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Vérifie si l'attribut correspond à ce que le Voter doit gérer
        return self::ADMIN_ROLE === $attribute;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false; // L'utilisateur n'est pas connecté
        }

        // Vérifie si l'utilisateur a le rôle ADMIN
        return in_array(User::ADMIN_ROLE, $user->getRoles());
    }
}
