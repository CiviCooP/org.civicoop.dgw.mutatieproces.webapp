<?php

namespace CiviCoop\InsiteAuthenticatorBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class InsiteUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {			
		$user = new InsiteUser($username, '');
		return $user;
    }

    public function refreshUser(UserInterface $user)
    {		
        if (!$user instanceof InsiteUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'CiviCoop\InsiteAuthenticatorBundle\Security\User\InsiteUser';
    }
}