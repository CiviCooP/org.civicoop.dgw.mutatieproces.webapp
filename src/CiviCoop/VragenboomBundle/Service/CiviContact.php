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

class CiviContact extends CiviCommon {
  
  protected $em;
  
  protected $factory;
  
  public function __construct(EntityManager $entityManager, Api $api, RapportFactory $factory) {
    parent::__construct($api);
    $this->em = $entityManager;
    $this->factory = $factory;
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
        $this->em->persist($client);
      }
    }
    $this->em->flush();
  }
  
}

