<?php

namespace CiviCoop\VragenboomBundle\Service;

use CiviCoop\CiviCrmBundle\Service\Api;
use CiviCoop\VragenboomBundle\Entity\AdviesRapport;
use CiviCoop\VragenboomBundle\Entity\Client;
use Doctrine\ORM\EntityManager;

class CiviCase extends CiviCommon {

	
	private $casetype;
	private $casetype_id;
	private $activitytype;
	private $activity_type_id;
	private $eindehuurcontract;
	private $eindehuurcontract_id;
	
	private $em;
	
	public function __construct(EntityManager $entityManager, Api $api, $casetype, $activitytype, $eindehuurcontract) {
		parent::__construct($api);
		$this->em = $entityManager;
		$this->casetype = $casetype;
		$this->activitytype = $activitytype;
		$this->eindehuurcontract = $eindehuurcontract;
		
		$this->eindehuurcontract_id = $this->retrieveCustomGroupIdByName($this->eindehuurcontract);		
		$this->activity_type_id = $this->retreiveOptionValueByname($this->activitytype, 'activity_type');
	}

	/**
	 * Sync cases from civi
	 */
	public function sync() {
		$this->syncExisting();
		$this->syncNew();
	}
	
	protected function syncExisting() {
		$reports = $this->em->getRepository('CiviCoopVragenboomBundle:AdviesRapport')->findAllActive();
		foreach($reports as $report) {
			$activity = $this->getActivity($report->getActivityId());
			if ($activity) {
				$report->setActivityId($activity->id);
				$report->setClosed(($activity->status_id == 1) ? false : true);
				$this->em->persist($report);
			} else {
				$report->setClosed(true);
				$this->em->persist($report);
			}
		}
		
		$this->em->flush();
	}
	 
	protected function syncNew() {
		
		$activities = $this->getActivities($this->activity_type_id);
		while($activity = $activities->nextValue()) {
			$cases = $this->getCaseByActivity($activity->id);
			$case = $cases->nextValue();
			if ($case) {
				$report = $this->em->getRepository('CiviCoopVragenboomBundle:AdviesRapport')->findOneByCaseId($case->id);
				if (!$report) {
					$report = new AdviesRapport();				
					$report->setCaseId($case->id);					
				} else { 
					$report->setClosed(false);
				}
				
				$report->setActivityId($activity->id);
				$custom = $this->retrieveCustomValuesByEntity('civicrm_case', $case->id, $this->eindehuurcontract_id);					
				if (isset($custom->hov_nr)) {
					$report->setHovNummer($custom->hov_nr);
				}
				if (isset($custom->vge_nr)) {
					$report->setVgeNummer($custom->vge_nr);
				}
				if (isset($custom->vge_adres)) {
					$report->setVgeAdres($custom->vge_adres);
				}
				
				foreach($case->client_id as $cid) {
					$client = $this->em->getRepository('CiviCoopVragenboomBundle:Client')->findOneByContactId($cid);
					
					if (!$client) {
						$contact = $this->retrieveContact($cid);
						$client = new Client();
						$client->setDisplayName($contact->display_name);
						$client->setContactId($contact->contact_id);
					}
					if (!$report->getClients()->contains($client)) {
						$report->addClient($client);
					}
				}
				
				$this->em->persist($report);
			}
		}
		
		$this->em->flush();
	}
	
	private function getActivities($activity_type_id) {
		//Haal alle activiteiten op met de status gepland (1).
		return $this->api->Activity->get(array('activity_type_id' => $activity_type_id, 'status_id' => 1, 'is_current_revision'=>1));
	}
	
	private function getActivity($activity_id) {
		$activity = $this->api->Activity->get(array('activity_id' => $activity_id));
		$activity = $activity->nextValue();
		if ($activity && $activity->is_current_revision == 0) {
			$activity = $this->getActivityByOriginalId($activity->id);
		}
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
	
	
}
