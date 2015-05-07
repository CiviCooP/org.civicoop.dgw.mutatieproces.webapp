<?php

namespace CiviCoop\VragenboomBundle\Entity;

use CiviCoop\VragenboomBundle\Entity\RapportRegelInterface;
use CiviCoop\VragenboomBundle\Entity\Attachment;

/**
 * This class holds common rapport functions
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 */
interface RapportInterface {
  
  /**
   * Returns a new regel object which can be added the report
   * @return RapportRegelInterface
   */
  public function getNewRegelClass();
  
  /**
   * Add a new regel to the report
   */
  public function addRegel(RapportRegelInterface $regel);
  
  /**
   * Get regels
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getRegels();
  
  /**
   * Set opmerkingen voor afdeling verhuur
   */
  public function setOpmAfdVerhuur($opmAfdVerhuur); 
  
  /**
   * get opmerkingen voor afdeling verhuur
   */
  public function getOpmAfdVerhuur(); 
  
    /**
   * Set caseId
   *
   * @param integer $caseId
   * @return RapportInterface
   */
  public function setCaseId($caseId);

  /**
   * Get caseId
   *
   * @return integer 
   */
  public function getCaseId();
  
  /**
   * Set activityId
   *
   * @param integer $activityId
   * @return AdviesRapport
   */
  public function setActivityId($activityId);

  /**
   * Get activityId
   *
   * @return integer 
   */
  public function getActivityId();
  
  /**
   * Remove all attachments from the rapport
   * 
   * @return RapportInterface
   */
  public function removeAllAttachments();
  
  /**
   * Adds an attachment
   * 
   * @return RapportInterface
   */
  public function addAttachment(Attachment $attachment);
  
  /**
   * Get attachments
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getAttachments();

  /**
   * Set future_address_in_first
   *
   * @param string $futureAddressInFirst
   * @return RapportInterface
   */
  public function setFutureAddressInFirst($futureAddressInFirst);

  /**
   * Get future_address_in_first
   *
   * @return string
   */
  public function getFutureAddressInFirst();

  /**
   * Set future_address
   *
   * @param string $futureAddress
   * @return RapportInterface
   */
  public function setFutureAddress($futureAddress);

  /**
   * Get future_address
   *
   * @return string
   */
  public function getFutureAddress();
  
  
}

