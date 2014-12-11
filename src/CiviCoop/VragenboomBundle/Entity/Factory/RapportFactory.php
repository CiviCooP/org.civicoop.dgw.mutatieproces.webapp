<?php

namespace CiviCoop\VragenboomBundle\Entity\Factory;

use CiviCoop\VragenboomBundle\Entity\RapportInterface;
use CiviCoop\VragenboomBundle\Entity\AdviesRapportRegel;
use CiviCoop\VragenboomBundle\Entity\Ruimte;
use CiviCoop\VragenboomBundle\Entity\Object;
use CiviCoop\VragenboomBundle\Entity\ActieDefinitie;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\Callback(methods={"isAllValid"})
 */
class RapportFactory {

  /**
   * @var Ruimte
   */
  private $ruimte;

  /**
   * @var Object
   */
  private $object;

  /**
   * @var ActieDefinitie
   */
  private $actie;

  /**
   * @var String
   */
  private $remark;

  /**
   * @var String
   */
  protected $verantwoordelijke;

  public function __construct() {
  }

  public function setRuimte(Ruimte $ruimte) {
    $this->ruimte = $ruimte;
    return $this;
  }

  public function setObject(Object $object) {
    $this->object = $object;
    return $this;
  }

  public function setActie(ActieDefinitie $actie) {
    $this->actie = $actie;
    return $this;
  }

  public function setRemark($remark) {
    $this->remark = $remark;
    return $this;
  }

  public function getRuimte() {
    return $this->ruimte;
  }

  public function getObject() {
    return $this->object;
  }

  public function getActie() {
    return $this->actie;
  }

  public function getRemark() {
    return $this->remark;
  }

  /**
   * Set verantwoordelijke
   *
   * @param string $verantwoordelijke
   * @return ActieDefinitie
   */
  public function setVerantwoordelijke($verantwoordelijke) {
    $this->verantwoordelijke = $verantwoordelijke;

    return $this;
  }

  /**
   * Get verantwoordelijke
   *
   * @return string 
   */
  public function getVerantwoordelijke() {
    return $this->verantwoordelijke;
  }

  /**
   * @param  ExecutionContext $context
   * @return bool
   */
  public function isAllValid(ExecutionContext $context) {
    if (!$this->object->getRuimtes()->contains($this->ruimte)) {
      $context->addViolation('Invalid object', array(), $this->object);
    }

    if ($this->object != $this->actie->getObject()) {
      $context->addViolation('Invalid actie', array(), $this->object);
    }

    //return true;
  }

  /**
   * Creates a new regel and adds it to the rapport
   * 
   * @param \CiviCoop\VragenboomBundle\Entity\RapportInterface $rapport
   * @return \CiviCoop\VragenboomBundle\Entity\RapportRegelInterface
   */
  public function make(RapportInterface $rapport) {
    $regel = $rapport->getNewRegelClass();
    $regel->setActieDefinitie($this->actie);
    
    $regel->setRuimte($this->getRuimte()->getNaam());
    $regel->setObject($this->getObject()->getNaam());
    $regel->setActie($this->actie->getActie());
    
    if (empty($this->remark)) {
      $regel->setRemark($this->actie->getDescription());
    } else {
      $regel->setRemark($this->remark);
    }    
        
    if (empty($this->verantwoordelijke)) {
      $regel->setVerantwoordelijke($this->actie->getVerantwoordelijke());
    } else {
      $regel->setVerantwoordelijke($this->verantwoordelijke);
    }

    $regel->setRapport($rapport);
    $rapport->addRegel($regel);

    return $regel;
  }

}
