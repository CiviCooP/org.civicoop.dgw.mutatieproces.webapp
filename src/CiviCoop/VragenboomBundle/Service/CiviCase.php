<?php

namespace CiviCoop\VragenboomBundle\Service;

use CiviCoop\CiviCrmBundle\Service\Api;
use CiviCoop\VragenboomBundle\Service\RapportFactory;
use CiviCoop\VragenboomBundle\Entity\Client;
use CiviCoop\VragenboomBundle\Entity\RapportInterface;
use CiviCoop\VragenboomBundle\Entity\AdviesRapport;
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
  private $info_afd_verhuur;
  private $info_afd_verhuur_id;
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
    $this->info_afd_verhuur = 'info_afd_verhuur';

    $this->eindehuurcontract_id = $this->retrieveCustomGroupIdByName($this->eindehuurcontract);
    $this->huuropzegging_id = $this->retrieveCustomGroupIdByName($this->huuropzegging);
    $this->info_afd_verhuur_id = $this->retrieveCustomGroupIdByName($this->info_afd_verhuur);
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
    foreach ($reports as $report) {
      $activity = $this->getCurrentActivity($report->getActivityId());
      if ($activity) {
        $report->setActivityId($activity->id);
        $report->setDate(new \DateTime($activity->activity_date_time));
        $report->setClosed(($activity->status_id == 1 && $activity->is_deleted != 1) ? false : true);
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
    while ($activity = $activities->nextValue()) {
      $activity_id = $activity->id;
      $cases = $this->getCaseByActivity($activity->id);
      $case = $cases->nextValue();
      if ($case && !$case->is_deleted) {
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

        $custom = $this->retrieveCustomValuesByEntity('civicrm_case', $case->id, $this->info_afd_verhuur_id);
        if (isset($custom->huuropzeg_rapport)) {
          $report->setOpmAfdVerhuur($custom->huuropzeg_rapport);
        }

        foreach ($case->client_id as $cid) {
          $client = $this->em->getRepository('CiviCoopVragenboomBundle:Client')->findOneByContactId($cid);

          if (!$client) {
            $contact = $this->retrieveContact($cid);
            $client = new Client();
            $client->setDisplayName($contact->display_name);
            $client->setContactId($contact->contact_id);
            if ($contact->email) {
              $client->setEmail($contact->email);
            }
            if ($contact->phone) {
              $client->setPhone($contact->phone);
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
    return $this->api->Activity->get(array('activity_type_id' => $activity_type_id, 'status_id' => 1, 'is_current_revision' => 1));
  }

  private function getCurrentActivity($activity_id) {
    $activity = $this->api->Activity->get(array('id' => $activity_id));
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

  public function closeActivity($activity_id, $details) {
    $this->api->Activity->create(array(
      'activity_id' => $activity_id,
      'details' => $details,
      'status_id' => 2, //closed
    ));
  }

  public function updateInfoAfdVerhuur(RapportInterface $rapport) {
    $custom = $this->updateCustomValuesByEntity('civicrm_case', $rapport->getCaseId(), $this->info_afd_verhuur_id, 'huuropzeg_rapport', $rapport->getOpmAfdVerhuur());
  }

  public function createEindopname(AdviesRapport $rapport, $civi_user_id) {
    $eindopname = $rapport->getEindopname();
    if (empty($eindopname)) {
      //eindopname datum is leeg
      return;
    }

    //kijk of er al een eindgesprek is ingepland voor dit dossier
    //als dat niet het geval is maak dan een nieuwe activiteit van het type eindgesprek aan
    //als dat wel het geval wijzig de datum en tijd
    $eindopname_activity_id = false;
    $cases = $this->api->Case->get(array('case_id' => $rapport->getCaseId()));
    $case = $cases->nextValue();
    if ($case) {
      foreach ($case->activities as $case_act_id) {
        $case_activity = $this->getCurrentActivity($case_act_id);
        if ($case_activity && $case_activity->activity_type_id == $this->activity_eindgesprek_type_id && $case_activity->status_id == 1 && $case_activity->is_deleted != '1') {
          $eindopname_activity_id = $case_activity->id;
          break;
        }
      }
    }

    $activity = false;
    try {
      $activities = $this->api->Activity->getsingle(array('id' => $rapport->getActivityId(), 'return[assignee_contact_id]' => 1, 'return[target_contact_id]' => 1));
      $activity = $activities->nextValue();
      //var_dump($activity); exit();
    } catch (Exception $e) {
      //do nothing
    }

    //$params['activity_date_time'] = $rapport->getEindopname()->format('Y-m-d H:i:s');
    $params['activity_date_time'] = $rapport->getEindopname()->format('YmdHis');
    if ($eindopname_activity_id) {
      //werk activiteit bij met nieuwe planning
      $params['id'] = $eindopname_activity_id;
      $this->api->Activity->Create($params);
    } else {
      $params['activity_type_id'] = $this->activity_eindgesprek_type_id;
      $params['status_id'] = '1';
      $params['subject'] = 'Eindopname';
      $params['case_id'] = $rapport->getCaseId();
      $params['source_contact_id'] = $civi_user_id;
      if ($activity) {
        $params['assignee_contact_id'] = implode(",", $activity->assignee_contact_id);
        $params['target_contact_id'] = implode(",", $activity->target_contact_id);
      }
      $this->api->Activity->Create($params);
    }
  }

}
