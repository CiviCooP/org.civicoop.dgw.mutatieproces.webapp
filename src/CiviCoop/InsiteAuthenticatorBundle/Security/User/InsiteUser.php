<?php

namespace CiviCoop\InsiteAuthenticatorBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class InsiteUser implements UserInterface
{
    private $username;
    private $password;
    private $roles;
	
	private $drupalUser;
	
	private $civiContactId;

    public function __construct($username, $password)
    {
        $this->username = $username;
		$this->password = $password;
		
		$this->roles = array('ROLE_USER');
    }
	
	public function setDrupalUser($user) {
		$this->drupalUser = $user;
	}
	
	public function getDrupalUser() {
		return $this->drupalUser;
	}
	
	public function setCiviContactId($contact_id) {
		$this->civiContactId = $contact_id;
	}
	
	public function getCiviContactId() {
		return $this->civiContactId;
	}

    public function getRoles()
    {
        return $this->roles;
    }
	
	public function getPassword() {
		return $this->password;
	}
	
	public function eraseCredentials() {
	}

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }
	
	/*public function __toString() {
		return serialize($this);
	}*/
}