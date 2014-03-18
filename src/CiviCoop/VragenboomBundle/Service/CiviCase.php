<?php

namespace CiviCoop\VragenboomBundle\Service;

use CiviCoop\CiviCrmBundle\Service\Api;
use CiviCoop\VragenboomBundle\Service\RapportFactory;
use CiviCoop\VragenboomBundle\Entity\Client;
use Doctrine\ORM\EntityManager;

class CiviCase extends CiviCommon {

	
	private $casetype;
	private $casetype_id;
	private $activitytype_adviesgesprek;
  private $activitytype_eindgesprek;
	private $activity_adviesgesprek_type_id;
  private $activity_eindgesprek_type_id;
	private $eindehuurcontract;
	private $eindehuurcontract_id;
  private $huuropzegging;
  private $huuropzegging_id;
  private $factory;
	
	private $em;
	
	public function __construct(EntityManager $entityManager, Api $api, RapportFactory $factory) {
		parent::__construct($api);
    $this->factory = $factory;
		$this->em = $entityManager;
		$this->casetype = 'Huuropzeggingsdossier';
		$this->activitytype_adviesgesprek = 'adviesgesprek_huuropzegging';
    $this->activitytype_eindgesprek = 'eindgesprek_huuropzegging';
		$this->eindehuurcontract = 'vge';
    $this->huuropzegging = 'huur_opzegging';
		
		$this->eindehuurcontract_id = $this->retrieveCustomGroupIdByName($this->eindehuurcontract);		
    $this->huuropzegging_id = $this->retrieveCustomGroupIdByName($this->huuropzegging);
		$this->activity_adviesgesprek_type_id = $this->retreiveOptionValueByname($this->activitytype_adviesgesprek, 'activity_type');
    $this->activity_eindgesprek_type_id = $this->retreiveOptionValueByname($this->activitytype_eindgesprek, 'activity_type');
	}

	/**
	 * Sync cases from civi
	 */
	public function sync() {
		$this->syncExisting();
    $this->syncNew();
	}
	
	protected function syncExisting() {
		$this->syncExistingActivity('CiviCoopVragenboomBundle:AdviesRapport');
    $this->syncExistingActivity('CiviCoopVragenboomBundle:EindRapport');
	}
  
  private function syncExistingActivity($entity) {
    $reports = $this->factory->findAllActive($entity);
		foreach($reports as $report) {
			$activity = $this->getActivity($report->getActivityId());
			if ($activity) {
				$report->setActivityId($activity->id);
        $report->setDate(new \DateTime($activity->activity_date_time));
				$report->setClosed(($activity->status_id == 1) ? false : true);
				$this->em->persist($report);
			} else {
				$report->setClosed(true);
				$this->em->persist($report);
			}
      $this->em->flush();
		}
  }
	 
	protected function syncNew() {		
    $this->syncNewActivity($this->activity_adviesgesprek_type_id, 'CiviCoopVragenboomBundle:AdviesRapport');
    $this->syncNewActivity($this->activity_eindgesprek_type_id, 'CiviCoopVragenboomBundle:EindRapport');
	}
  
  private function syncNewActivity($activity_type_id, $entity) {
    $activities = $this->getActivities($activity_type_id);
		while($activity = $activities->nextValue()) {
      $activity_id = $activity->id;
			$cases = $this->getCaseByActivity($activity->id);
			$case = $cases->nextValue();
			if ($case) {
				$report = $this->factory->findOneByCaseId($entity, $case->id);
				if (!$report) {
					$report = $this->factory->getNewClass($entity);		
					$report->setCaseId($case->id);					
				} else { 
					$report->setClosed(false);
				}
				
				$report->setActivityId($activity_id);
        $report->setDate(new \DateTime($activity->activity_date_time));
				$custom = $this->retrieveCustomValuesByEntity('civicrm_case', $case->id, $this->eindehuurcontract_id);					
				if (isset($custom->vge_nr)) {
					$report->setVgeNummer($custom->vge_nr);
				}
				if (isset($custom->vge_adres)) {
					$report->setVgeAdres($custom->vge_adres);
				}
        
        $custom = $this->retrieveCustomValuesByEntity('civicrm_case', $case->id, $this->huuropzegging_id);					
        if (isset($custom->hov_nr)) {
					$report->setHovNummer($custom->hov_nr);
				}
        if (isset($custom->verwachte_eind_datum)) {
          $report->setExpectedEndDate(new \DateTime($custom->verwachte_eind_datum));
        }
				
				foreach($case->client_id as $cid) {
					$client = $this->em->getRepository('CiviCoopVragenboomBundle:Client')->findOneByContactId($cid);
					
					if (!$client) {
						$contact = $this->retrieveContact($cid);
						$client = new Client();
						$client->setDisplayName($contact->display_name);
						$client->setContactId($contact->contact_id);
            if ($contact->email) {
              $client->setEmail($contact->email);
            }
					}
					if (!$report->getClients()->contains($client)) {
						$report->addClient($client);
					}
				}
				
				$this->em->persist($report);
        $this->em->flush();
			}
		}
  }
	
	private function getActivities($activity_type_id) {
		//Haal alle activiteiten op met de status gepland (1).
		return $this->api->Activity->get(array('activity_type_id' => $activity_type_id, 'status_id' => 1, 'is_current_revision'=>1));
	}
	
	private function getActivity($activity_id) {
		$activity = $this->api->Activity->get(array('id' => $activity_id));
		$activity = $activity->nextValue();
		/*if ($activity && $activity->is_current_revision == 0) {
			$activity = $this->getActivityByOriginalId($activity->id);
		}*/
		return $activity;
	}
	
	private function getActivityByOriginalId($activity_id) {
		$activity = $this->api->Activity->get(array('original_id' => $activity_id));
		$activity = $activity->nextValue();
		if ($activity && $activity->is_current_revision == 0) {
			$activity = $this->getActivityByOriginalId($activity->id);
		}
		return $activity;
	}
	
	private function getCaseByActivity($activity_id) {
		return $this->api->Case->get(array('activity_id' => $activity_id));
	}
	
  public function closeActivity($activity_id, $details) {
    $this->api->Activity->create(array(
        'activity_id' => $activity_id,
        'details' => $details,
        'status_id' => 2, //closed
    ));
  }
	
}
