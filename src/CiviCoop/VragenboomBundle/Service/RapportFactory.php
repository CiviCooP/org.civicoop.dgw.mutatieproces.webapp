<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CiviCoop\VragenboomBundle\Service;

use Doctrine\ORM\EntityManager;
use CiviCoop\VragenboomBundle\Entity\AdviesRapport;
use CiviCoop\VragenboomBundle\Entity\EindRapport;
use CiviCoop\VragenboomBundle\Form\AdviesRapportType;
use CiviCoop\VragenboomBundle\Form\EindRapportType;
use Symfony\Component\Translation\TranslatorInterface;

class RapportFactory {
  
  protected $em;
  protected $translator;
  
  public function __construct(EntityManager $entityManager, TranslatorInterface $translator) {
    $this->em = $entityManager;
    $this->translator = $translator;
  }
  
  /**
   * 
   * @param string $entity
   * @return returns a list of rapports which are active
   */
  public function findAllActive($entity) {
    $this->checkEntity($entity);
    return $this->em->getRepository($entity)->findAllActive();
  }
  
  public function findAllCombinedActive() {
    $eind = $this->findAllActive('CiviCoopVragenboomBundle:EindRapport');
    $advies = $this->findAllActive('CiviCoopVragenboomBundle:AdviesRapport');
    $return = array();
    foreach($eind as $report) {
      $index = $report->getDate()->getTimestamp();
      $index = $this->getNewIndex($return, $index);
      $return[$index] = $report;
    }
    foreach($advies as $report) {
      $index = $report->getDate()->getTimestamp();
      $index = $this->getNewIndex($return, $index);
      $return[$index] = $report;
    }
    ksort($return);
    return $return;
  }
  
  private function getNewIndex($array, $index) {
    $i = $index;
    while(isset($array[$i])) {
      $i++;
    }
    return $i;
  }
  
  /**
   * 
   * @param string $entity
   * @param int $caseId
   * @return returns a report of type entity which is linked to a caseId, or false when not found
   */
  public function findOneByCaseId($entity, $caseId) {
     $this->checkEntity($entity);
    return $this->em->getRepository($entity)->findOneByCaseId($caseId);
  }
  
  /**
   * 
   * @param string $entity
   * @return returns a new class for a rapport type
   */
  public function getNewClass($entity) {
    $this->checkEntity($entity);
    
    switch ($entity) {
      case 'CiviCoopVragenboomBundle:EindRapport':
        return new EindRapport();
        break;
      case 'CiviCoopVragenboomBundle:AdviesRapport':
        return new AdviesRapport();
        break;
    }
  }
  
  /**
   * 
   * @param string $entity
   * @return returns a new class for a rapport type
   */
  public function getNewForm($entity) {
    $this->checkEntity($entity);
    
    switch ($entity) {
      case 'CiviCoopVragenboomBundle:EindRapport':
        return new EindRapportType();
        break;
      case 'CiviCoopVragenboomBundle:AdviesRapport':
        return new AdviesRapportType();
        break;
    }
  }
  
  /**
   * 
   * @param type $entity
   * @return returns a rapport generator class for the entity
   */
  public function getRapportGenerator($entity) {
    $this->checkEntity($entity);
    switch ($entity) {
      case 'CiviCoopVragenboomBundle:EindRapport':
        return new EindRapportGenerator();
        break;
      case 'CiviCoopVragenboomBundle:AdviesRapport':
        return new AdviesRapportGenerator();
        break;
    }
  }
  
  /**
   * 
   * @param type $object
   * @return returns the entity name
   * @throws Exception
   */
  public function getEntity($object) {
    switch (get_class($object)) {
      case 'CiviCoop\VragenboomBundle\Entity\EindRapport':
        return 'CiviCoopVragenboomBundle:EindRapport';
        break;
      case 'CiviCoop\VragenboomBundle\Entity\AdviesRapport':
        return 'CiviCoopVragenboomBundle:AdviesRapport';
        break;
    }
    throw new Exception("unknown object type");
  }
  
  public function getHumanName($object) {
    $entity = $this->getEntity($object);
    $this->checkEntity($entity);
    switch ($entity) {
      case 'CiviCoopVragenboomBundle:EindRapport':
        return $this->translator->trans('Eindopname');
        break;
      case 'CiviCoopVragenboomBundle:AdviesRapport':
        return $this->translator->trans('Vooropname');
        break;
    }
  }
  
  public function getShortName($object) {
    $entity = $this->getEntity($object);
    $this->checkEntity($entity);
    switch ($entity) {
      case 'CiviCoopVragenboomBundle:EindRapport':
        return 'eindopname';
        break;
      case 'CiviCoopVragenboomBundle:AdviesRapport':
        return 'vooropname';
        break;
    }
  }
  
  public function getEntityFromShortname($shortname) {
    switch ($shortname) {
      case 'eindopname':
        return 'CiviCoopVragenboomBundle:EindRapport';
        break;
      case 'vooropname':
        return 'CiviCoopVragenboomBundle:AdviesRapport';
        break;
    }
    throw new Exception("invalid shortname");
  }
  
  protected function checkEntity($entity) {
    switch ($entity) {
      case 'CiviCoopVragenboomBundle:EindRapport':
      case 'CiviCoopVragenboomBundle:AdviesRapport':
        return true;
        break;
    }
    throw new Exception("Invalid entity: ".$entity);
  }
  
}