<?php

namespace CiviCoop\VragenboomBundle\Entity;

use CiviCoop\VragenboomBundle\Entity\RapportRegelInterface;

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
}

