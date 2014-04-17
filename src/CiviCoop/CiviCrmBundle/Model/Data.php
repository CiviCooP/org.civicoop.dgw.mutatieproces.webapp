<?php

namespace CiviCoop\CiviCrmBundle\Model;

class Data {
	
	protected $api;
	
	protected $entity;
	
	protected $action;
	
	protected $parameters;
	
	protected $values;
	
	protected $firstValue = null;
	
	public function __construct($api, $entity, $action, $parameters) {
		$this->api = $api;
		$this->entity = $entity;
		$this->action = $action;
		$this->parameters = $parameters;
		
		$this->values = $this->api->values();
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function getEntity() {
		return $this->entity;
	}
	
	public function getParameters() {
		return $this->parameters;
	}
	
	public function nextValue() {
		if (null === $this->firstValue) {
			$this->firstValue = reset($this->values);
			$currentValue = $this->firstValue;
		} else {
			$currentValue = next($this->values);
		}
		return $currentValue;
	}
	
	public function getAsArray() {
		$return = array();
		while($value = $this->nextValue()) {
			$return[$value->id] = $value;
		}
		return $return;
	}
	
}