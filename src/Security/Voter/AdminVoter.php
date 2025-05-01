<?php

     namespace App\Security\Voter;

     use App\Entity\User;
     use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
     use Symfony\Component\Security\Core\Authorization\Voter\Voter;

     class AdminVoter extends Voter
     {
         private const ADMIN_ROLE = 'ROLE_ADMIN';

         protected function supports(string $attribute, mixed $subject): bool
         {
             // Vérifie si l'attribut correspond à ce que le Voter doit gérer
             return $attribute === self::ADMIN_ROLE;
         }

         protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
         {
             $user = $token->getUser();

             if (!$user instanceof User) {
                 return false; // L'utilisateur n'est pas connecté
             }

             dd($attribute, $subject, $token);

             // Vérifie si l'utilisateur a le rôle ADMIN
             return isset($user->getRoles()[User::ADMIN_ROLE]);
         }
     }

