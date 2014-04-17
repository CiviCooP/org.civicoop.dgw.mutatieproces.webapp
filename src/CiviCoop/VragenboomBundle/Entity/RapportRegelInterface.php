<?php

namespace CiviCoop\VragenboomBundle\Entity;

/* 
 * Interface class for rapport regels
 * Every rapport type can have its own type of regels
 */
interface RapportRegelInterface {
  
  /**
   * Set remark
   *
   * @param string $remark
   * @return AdviesRapportRegel
   */
  public function setRemark($remark);

  /**
   * Get remark
   *
   * @return string 
   */
  public function getRemark();

  /**
   * Set rapport
   *
   * @param \CiviCoop\VragenboomBundle\Entity\RapportInterface $adviesRapport
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setRapport(\CiviCoop\VragenboomBundle\Entity\RapportInterface $rapport = null);

  /**
   * Get rapport
   *
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface 
   */
  public function getRapport();

  /**
   * Set actie
   *
   * @param \CiviCoop\VragenboomBundle\Entity\ActieDefinitie $actie
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setActieDefinitie(\CiviCoop\VragenboomBundle\Entity\ActieDefinitie $actie = null);

  /**
   * Get actie
   *
   * @return \CiviCoop\VragenboomBundle\Entity\ActieDefinitie 
   */
  public function getActieDefinitie();

  /**
   * Set verantwoordelijke
   *
   * @param string $verantwoordelijke
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setVerantwoordelijke($verantwoordelijke);

  /**
   * Get verantwoordelijke
   *
   * @return string 
   */
  public function getVerantwoordelijke();

  public function getRuimte();

  public function getObject();

  public function getActie();

  public function getActieRemark();

  /**
   * Set ruimte
   *
   * @param string $ruimte
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setRuimte($ruimte);

  /**
   * Set object
   *
   * @param string $object
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setObject($object);

  /**
   * Set actie
   *
   * @param string $actie
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setActie($actie);

  /**
   * Set actie remark
   *
   * @param string $actieRemark
   * @return \CiviCoop\VragenboomBundle\Entity\RapportInterface
   */
  public function setActieRemark($actieRemark);
  
}

