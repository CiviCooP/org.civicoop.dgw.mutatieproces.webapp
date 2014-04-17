<?php

namespace CiviCoop\CiviCrmBundle\Exception;

class CiviCrmApiError extends \Exception implements CiviCrmApiErrorInterface {

	protected $civiErrorMsg = "";
	
	protected $entity;
	
	protected $action;
	
	protected $parameters;
	
	public function __construct ($message, $entity, $action, $parameters, $code = 0, Exception $previous = NULL) {
		$this->civiErrorMsg = $message;
		$this->entity = $entity;
		$this->action = $action;
		$this->parameters = $parameters;
		$msg = "CiviCrm API returned with the following response: ".$message;
		parent::__construct ($msg, $code, $previous);
	}
	
	public function getApiErrorMessage() {
		return $this->civiErrorMsg;
	}
	
	public function getEntity() {
		return $this->entity;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function getParameters() {
		return $this->parameters;
	}

}