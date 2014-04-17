<?php

namespace CiviCoop\CiviCrmBundle\Exception;
/**
 * Interface for my bundle exceptions.
 */
interface CiviCrmApiErrorInterface
{
	public function getApiErrorMessage();
	
	public function getEntity();
	
	public function getAction();
	
	public function getParameters();
}