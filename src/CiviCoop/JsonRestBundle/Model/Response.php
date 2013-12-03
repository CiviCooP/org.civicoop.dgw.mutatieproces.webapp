<?php

namespace CiviCoop\JsonRestBundle\Model;

class Response {
	
	private $data;
	
	private $statusCode;
	
	public function __construct($statusCode, $data) {
		$this->statusCode = $statusCode;
		$this->data = $data;
	}
	
	public function getStatusCode() {
		return $this->statusCode;
	}
	
	public function getData() {
		return $this->data;
	}
	
}