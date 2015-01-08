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
  
  
}

