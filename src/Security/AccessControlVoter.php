<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AccessControlVoter extends Voter
{
    const ACCESS_GRANTED = 'ACCESS_GRANTED';

    protected function supports(string $attribute, $subject): bool
    {
        // On vérifie que l'attribut de la règle est bien 'ACCESS_GRANTED' et que le sujet est une instance de User
        return self::ACCESS_GRANTED === $attribute && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // L'utilisateur doit avoir l'accès si il n'est pas banni
        $user = $subject;
        dump($user->getRole()->value);
        if ($user->getRole()->value === 'banned') {
            return false; // Refuser l'accès aux utilisateurs bannis
        }

        return true; // Autoriser l'accès aux autres utilisateurs
    }
}
