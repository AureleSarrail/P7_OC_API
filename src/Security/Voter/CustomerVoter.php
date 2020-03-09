<?php

namespace App\Security\Voter;

use App\Entity\Customer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter extends Voter
{
    const CUSTOMER_DELETE = 'CUSTOMER_DELETE';

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['CUSTOMER_DELETE'])
            && $subject instanceof Customer;
    }

    /**
     * @param string $attribute
     * @param Customer $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CUSTOMER_DELETE:
                return $subject->getUser() === $user;
                break;
        }

        return false;
    }
}
