<?php

namespace Acme\DemoBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class WebserviceUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
		//check if user exists in Drupal....
		$userData = array("username" => "jaap", "password" => "jaap1234", "salt" => "", "roles" => array('ROLE_USER'));
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $username = $userData['username'];
            $password = $userData['password'];
            $salt = $userData['salt'];
            $roles = $userData['roles'];
			
			$user = new WebserviceUser($username, $password, $salt, $roles);
			return $user;
		}

        //throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Acme\WebserviceUserBundle\Security\User\WebserviceUser';
    }
}