<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use CiviCoop\VragenboomBundle\Entity\RapportInterface;
use CiviCoop\VragenboomBundle\Entity\RapportRegelInterface;

/**
 * EindRapportRegel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CiviCoop\VragenboomBundle\Entity\EindRapportRegelRepository")
 */
class EindRapportRegel implements RapportRegelInterface {

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="remark", type="text", nullable=true)
   */
  private $remark;

  /**
   * @ORM\ManyToOne(targetEntity="EindRapport", inversedBy="regels")
   * @ORM\JoinColumn(name="eindrapport_id", referencedColumnName="id")
   */
  protected $eindRapport;

  /**
   * @ORM\ManyToOne(targetEntity="ActieDefinitie")
   * @ORM\JoinColumn(name="actiedefinitie_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
   */
  protected $actie_definitie;

  /**
   * @Assert\NotBlank()
   * @ORM\Column(name="ruimte", type="string", length=255)
   */
  protected $ruimte;

  /**
   * @Assert\NotBlank()
   * @ORM\Column(name="object", type="string", length=255)
   */
  protected $object;

  /**
   * @Assert\NotBlank()
   * @ORM\Column(name="actie", type="string", length=255)
   */
  protected $actie;

  /**
   * @var string
   *
   * @ORM\Column(name="actie_remark", type="text", nullable=true)
   */
  private $actieRemark;

  /**
   * @Assert\NotBlank()
   * @ORM\Column(name="verantwoordelijke", type="string", length=255)
   */
  protected $verantwoordelijke;
  
  /**
   * @ORM\Column(name="status", type="string", length=255)
   */
  protected $status = '';
  
  /**
    * @ORM\ManyToOne(targetEntity="AdviesRapportRegel")
    * @ORM\JoinColumn(name="advies_rapport_regel_id", referencedColumnName="id", nullable=true)
    */
  protected $adviesRapportRegel;

  public function __construct() {
    
  }

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set remark
   *
   * @param string $remark
   * @return AdviesRapportRegel
   */
  public function setRemark($remark) {
    $this->remark = $remark;

    return $this;
  }

  /**
   * Get remark
   *
   * @return string 
   */
  public function getRemark() {
    return $this->remark;
  }

  /**
   * Set adviesRapport
   *
   * @param \CiviCoop\VragenboomBundle\Entity\AdviesRapport $eindRapport
   * @return EindRapportRegel
   */
  public function setRapport(\CiviCoop\VragenboomBundle\Entity\RapportInterface $eindRapport = null) {
    $this->eindRapport = $eindRapport;

    return $this;
  }

  /**
   * Get eindRapport
   *
   * @return \CiviCoop\VragenboomBundle\Entity\EindRapport 
   */
  public function getRapport() {
    return $this->eindRapport;
  }

  /**
   * Set actie
   *
   * @param \CiviCoop\VragenboomBundle\Entity\ActieDefinitie $actie
   * @return AdviesRapportRegel
   */
  public function setActieDefinitie(\CiviCoop\VragenboomBundle\Entity\ActieDefinitie $actie = null) {
    $this->actie_definitie = $actie;    
    return $this;
  }

  /**
   * Get actie
   *
   * @return \CiviCoop\VragenboomBundle\Entity\ActieDefinitie 
   */
  public function getActieDefinitie() {
    return $this->actie_definitie;
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

  public function getRuimte() {
    return $this->ruimte;
  }

  public function getObject() {
    return $this->object;
  }

  public function getActie() {
    return $this->actie;
  }

  public function getActieRemark() {
    return $this->actieRemark;
  }

  public function setRuimte($ruimte) {
    $this->ruimte = $ruimte;
    return $this;
  }

  public function setObject($object) {
    $this->object = $object;
    return $this;
  }

  public function setActie($actie) {
    $this->actie = $actie;
    return $this;
  }

  public function setActieRemark($actieRemark) {
    $this->actieRemark = $actieRemark;
    return $this;
  }
  
  public function setStatus($status) {
    $this->status = $status;
    return $this;
  }
  
  public function getStatus() {
    return $this->status;
  }
  
  public function setAdviesRapportRegel(\CiviCoop\VragenboomBundle\Entity\AdviesRapportRegel $regel) {
    $this->adviesRapportRegel = $regel;
    if ($regel !== null) {
      $this->actieRemark = $regel->getActieRemark();
      $this->actie = $regel->getActie();
      $this->actie_definitie = $regel->getActieDefinitie();
      $this->remark = $regel->getRemark();
      $this->ruimte = $regel->getRuimte();
      $this->object = $regel->getObject();
      $this->verantwoordelijke = $regel->getVerantwoordelijke();
    }    
    return $this;
  }
  
  public function getAdviesRapportRegel() {
    return $this->adviesRapportRegel;
  }

}
