<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CiviCoop\InsiteAuthenticatorBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * UsernamePasswordToken implements a username and password token.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class InsiteUserToken extends UsernamePasswordToken
{
    
    private $civi_id;
    
    private $drupal_id;

    /**
     * Constructor.
     *
     * @param string          $user        The username (like a nickname, email address, etc.), or a UserInterface instance or an object implementing a __toString method.
     * @param string          $credentials This usually is the password of the user
     * @param string          $providerKey The provider key
     * @param RoleInterface[] $roles       An array of roles
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($user, $credentials, $providerKey, array $roles = array(), $civi_id=false, $drupal_id=false)
    {
        parent::__construct($user, $credentials, $providerKey,$roles);

        $this->civi_id = $civi_id;
        $this->drupal_id = $drupal_id;
    }

    

    public function getCiviId()
    {
        return $this->civi_id;
    }

    public function getDrupalId()
    {
        return $this->drupal_id;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();

        $this->civi_id = null;
        $this->drupal_id = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array($this->civi_id, $this->drupal_id, parent::serialize()));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->civi_id, $this->drupal_id, $parentStr) = unserialize($serialized);
        parent::unserialize($parentStr);
    }
}
