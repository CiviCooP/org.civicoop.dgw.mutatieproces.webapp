<?php

namespace CiviCoop\InsiteAuthenticatorBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class InsiteUserToken extends AbstractToken
{
	
	public $username;
	
	public $credentials;

    /*public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        // If the user has roles, consider it authenticated
        $this->setAuthenticated(count($roles) > 0);
    }*/

    public function getCredentials()
    {
        return '';
    }
}