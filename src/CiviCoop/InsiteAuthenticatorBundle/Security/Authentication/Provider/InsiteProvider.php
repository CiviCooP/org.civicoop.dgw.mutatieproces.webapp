<?php

namespace CiviCoop\InsiteAuthenticatorBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use CiviCoop\InsiteAuthenticatorBundle\Security\Authentication\Token\InsiteUserToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use CiviCoop\InsiteAuthenticatorBundle\Security\User\InsiteUser;

class InsiteProvider implements AuthenticationProviderInterface
{	
	private $providerKey;
	private $http;
	private $url;
	private $hostname;
	private $api;
	private $logger;

    public function __construct($http, $url, $hostname, $api, $logger)
    {
		$this->http = $http;
		$this->url = $url;
		$this->api = $api;
		$this->logger = $logger;
		$this->hostname = $hostname;
    }

    public function authenticate(TokenInterface $token)
    {	
		$response = $this->http->performPostRequest($this->url."/user/login", array('username' => $token->getUsername(), 'password' => $token->getCredentials()), $this->hostname);
		if ($response->getStatusCode() == 200) {
				$user = new InsiteUser($token->getUsername(), $token->getCredentials(), array('ROLE_USER'));
				$user->setDrupalUser($response->getData()->user);
				
				/** retrieve civi contact id **/
				try {
					$data = $this->api->UFMatch->getSingle(array('uf_id' => $user->getDrupalUser()->uid));
					$values = $data->nextValue();
					
					if ($values) {
						$user->setCiviContactId($values->contact_id);
					}
				} catch (\Exception $e) {
					$this->logger->warn($e->getMessage());
				}
				
        $authenticatedToken = new UsernamePasswordToken($user, $token->getCredentials(), $token->getProviderKey(), $user->getRoles());
				$authenticatedToken->setAttributes($token->getAttributes());
        $authenticatedToken->setAttribute('civicrm_contact_id', $user->getCiviContactId());
        $authenticatedToken->setAttribute('drupal_user_id', $user->getDrupalUser()->uid);
        
				return $authenticatedToken;
                
		}
		
        throw new AuthenticationException('Bad credentials');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken;
    }
}