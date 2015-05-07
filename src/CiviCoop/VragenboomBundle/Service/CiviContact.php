<?php

/* 
 * Class to sync existing clients between civi and this app
 * It only updates the data in this app with data from civi
 * 
 */

namespace CiviCoop\VragenboomBundle\Service;

use CiviCoop\CiviCrmBundle\Service\Api;
use CiviCoop\VragenboomBundle\Service\RapportFactory;
use Doctrine\ORM\EntityManager;
use CiviCoop\VragenboomBundle\Entity\Client;
use CiviCoop\CiviCrmBundle\Exception\CiviCrmApiError;

class CiviContact extends CiviCommon {
  
  protected $em;
  
  protected $factory;
  
  public function __construct(EntityManager $entityManager, Api $api, RapportFactory $factory) {
    parent::__construct($api);
    $this->em = $entityManager;
    $this->factory = $factory;
  }
  
  /**
   * Update a record in civicrm from the client object
   * 
   * @param \CiviCoop\VragenboomBundle\Entity\Client $client
   */
  public function updateContact(Client $client) {
    //one field to update and that is the primary email address
    //first get the id of the email field
    $params['email'] = $client->getEmail();
    $params['contact_id'] = $client->getContactId();
    try { 
      $result = $this->api->Email->getsingle(array('contact_id' => $client->getContactId(), 'is_primary' => '1'));
      $data = $result->nextValue();
      if ($data->id) {
        $params['id'] = $data->id;
      }
    } catch (CiviCrmApiError $e) {
      ;
    }
    if ($client->getEmail()) {
      $this->api->Email->create($params);
    }
    
    //update the primary phone number
    //first get the id of the phone field
    $params['phone'] = $client->getPhone();
    $params['contact_id'] = $client->getContactId();
    try {
      $result = $this->api->Phone->getsingle(array('contact_id' => $client->getContactId(), 'is_primary' => '1'));
      $data = $result->nextValue();
      if ($data->id) {
        $params['id'] = $data->id;
      }
    } catch (CiviCrmApiError $e) {
      ;
    }
    if ($client->getPhone()) {
      $this->api->Phone->create($params);
    }
  }
  
  public function sync() {
    $this->syncExisting();
  }
  
  protected function syncExisting() {
    $this->syncExistingActivity('CiviCoopVragenboomBundle:AdviesRapport');
    $this->syncExistingActivity('CiviCoopVragenboomBundle:EindRapport');
  }
  
  /**
   * Only sync clients from active activities (reports)
   * 
   * @param String $entity
   */
  private function syncExistingActivity($entity) {
    $reports = $this->factory->findAllActive($entity);
    foreach($reports as $report) {
      foreach($report->getClients() as $client) {
        $contact = $this->retrieveContact($client->getContactId());
        $client->setDisplayName($contact->display_name);
        if ($contact->email) {
          $client->setEmail($contact->email);
        } else {
          $client->setEmail(null);
        }
        if ($contact->phone) {
          $client->setPhone($contact->phone);
        } else {
          $client->setPhone(null);
        }
        $this->em->persist($client);
      }
    }
    $this->em->flush();
  }
  
}

