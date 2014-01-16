<?php

namespace CiviCoop\VragenboomBundle\Service;

use CiviCoop\CiviCrmBundle\Service\Api;

abstract class CiviCommon {

	protected $api;
	
	private $_cache;
	
	public function __construct(Api $api) {
		$this->api = $api;
	}
	
	protected function retreiveOptionValueByname($name, $group_name) {
		$data = $this->api->OptionGroup->getSingle(array('name' => $group_name));
		$values = $data->nextValue();
		if (!$values) {
			Throw new \Exception("No case types found in CiviCrm");
		}
		$option_group_id = $values->id;

		$data = $this->api->OptionValue->getSingle(array('option_group_id' => $option_group_id, 'name' => $name));
		$values = $data->nextValue();
		if (!$values) {
			Throw new \Exception("No case types found in CiviCrm");
		}
		return $values->value;	
	}
	
	protected function getCustomValues($entity_table, $entity_id, $return = array()) {
		$params['entity_table'] = $entity_table;
		$params['entity_id'] = $entity_id;
		foreach($return as $group => $fields) {
			foreach($fields as $field) {
				$params['return.'.$group.':'.$field] = '1';
			}
		}
		return $this->api->CustomValue->get($params);
	}	
	
	protected function retrieveCustomValuesByEntity($entity_table, $entity_id, $group_id) {
		$customValues = $this->getCustomValues($entity_table, $entity_id);
				
		if (!isset($this->_cache['fields_'.$group_id])) {
			$customFields = $this->api->CustomField->get(array('custom_group_id' => $group_id));
			$this->_cache['fields_'.$group_id] = $customFields->getAsArray();
			$fields = $customFields->getAsArray();
		}
		
		$fields = $this->_cache['fields_'.$group_id];
		
		$return = array();
		while($custom = $customValues->nextValue()) {
			if (!isset($custom->entity_id)) {
				continue;
			}
			if (!isset($return[$custom->entity_id])) {
				$return[$custom->entity_id] = new \stdClass();
			}
			if (isset($fields[$custom->id])) {
				$field = $fields[$custom->id];
				$fname = $field->name;
				$return[$custom->entity_id]->$fname = $custom->latest;
			}
		}
		
		if (isset($return[$entity_id])) {
			return $return[$entity_id];
		}
		
		return new \stdClass();
	}
	
	protected function retrieveCustomGroupIdByName($name) {
		$data = $this->api->CustomGroup->getSingle(array('name' => $name));
		$value = $data->nextValue();
		if (!$value) {
			throw new \Exception("Customgroup not found in civicrm");
		}
		return $value->id;
	}
	
	protected function retrieveContact($id) {
		if (!isset($this->_cache['contact_'.$id])) {
			$contact = $this->api->Contact->get(array('contact_id' => $id));
			$this->_cache['contact_'.$id] = $contact->nextValue();
		}
		$contact = $this->_cache['contact_'.$id];
		
		if (!$contact) {
			throw new \Exception("Contact not found in civicrm");
		}
		
		return $contact;
	}
}
