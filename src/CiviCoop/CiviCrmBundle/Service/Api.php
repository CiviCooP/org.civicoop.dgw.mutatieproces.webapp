<?php

namespace CiviCoop\CiviCrmBundle\Service;

use CiviCoop\CiviCrmBundle\Exception\CiviCrmApiError;
use CiviCoop\CiviCrmBundle\Model\Data;

class Api
{    
	private $conf;
	private $currentEntity;
	
	public function __construct($url, $api_key, $site_key, $path="") {
		$this->conf = array(
			'server' => $url,
			'api_key' => $api_key,
			'key' => $site_key,
		);
		
		if (strlen($path)) {
			$this->conf['path'] = $path;
		}
	}
	
	public function __call($action, $parameters) {
		require_once(__DIR__.'/../lib/civicrm/api/class.api.php');
		$api = new \civicrm_api3($this->conf);
		$entity = $this->currentEntity;
		
		$params = $this->checkParameters($parameters); 
		if ($params === false) {
			throw new \Exception("Invalid parameters given to api call");
		}

		if (!$api->$entity->$action($params)) {
			throw new CiviCrmApiError($api->error_message, $entity, $action, $params);
		}
		return new Data($api, $entity, $action, $params);
	}
	
	private function checkParameters($parameters) {
		if (is_array($parameters) && count($parameters) == 1 && isset($parameters[0]) && is_array($parameters[0])) {
			return $parameters[0];
		}
		return false;
	}
	
	public function __get($name) {
		$this->currentEntity = $name;
		return $this;
	}
}