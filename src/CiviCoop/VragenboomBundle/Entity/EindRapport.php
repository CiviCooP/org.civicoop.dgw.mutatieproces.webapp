<?php

namespace CiviCoop\VragenboomBundle\Entity;

use CiviCoop\VragenboomBundle\Entity\RapportInterface;
use CiviCoop\VragenboomBundle\Entity\RapportRegelInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EindRapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CiviCoop\VragenboomBundle\Entity\EindRapportRepository")
 */
class EindRapport implements RapportInterface {

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var integer
   *
   * @ORM\Column(name="case_id", type="integer")
   */
  private $caseId;

  /**
   * @var integer
   *
   * @ORM\Column(name="activity_id", type="integer")
   */
  private $activityId;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="expected_enddate", type="datetime", nullable=true)
   */
  private $expectedEndDate;

  /**
   * @var string
   *
   * @ORM\Column(name="hov_nummer", type="string", length=255, nullable=true)
   */
  private $hovNummer;

  /**
   * @var string
   *
   * @ORM\Column(name="vge_nummer", type="string", length=255, nullable=true)
   */
  private $vgeNummer;

  /**
   * @var string
   *
   * @ORM\Column(name="vge_adres", type="string", length=255, nullable=true)
   */
  private $vgeAdres;

  /**
   * @var string
   *
   * @ORM\Column(name="remarks", type="text")
   */
  private $remarks = "";

  /**
   * @var boolean
   *
   * @ORM\Column(name="closed", type="boolean")
   */
  private $closed = false;

  /**
   * @ORM\OneToMany(targetEntity="Client", mappedBy="adviesrapport", cascade={"persist"})
   */

  /**
   * @ORM\ManyToMany(targetEntity="Client", cascade={"persist"})
   * @ORM\JoinTable(name="eindrapport_client",
   *      joinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="eindrapport_id", referencedColumnName="id")}
   *      )
   * */
  private $clients;

  /**
   * @ORM\OneToMany(targetEntity="EindRapportRegel", mappedBy="eindRapport")
   */
  private $regels;

  public function __construct() {
    $this->regels = new ArrayCollection();
    $this->clients = new ArrayCollection();
    $this->date = new \DateTime();
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
   * Set caseId
   *
   * @param integer $caseId
   * @return EindRapport
   */
  public function setCaseId($caseId) {
    $this->caseId = $caseId;

    return $this;
  }

  /**
   * Get caseId
   *
   * @return integer 
   */
  public function getCaseId() {
    return $this->caseId;
  }

  /**
   * Set date
   *
   * @param \DateTime $date
   * @return EindRapport
   */
  public function setDate($date) {
    $this->date = $date;

    return $this;
  }

  /**
   * Get date
   *
   * @return \DateTime 
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Set expected end date
   *
   * @param \DateTime $date
   * @return AdviesRapport
   */
  public function setExpectedEndDate($date) {
    $this->expectedEndDate = $date;

    return $this;
  }

  /**
   * Get expected enddate
   *
   * @return \DateTime 
   */
  public function getExpectedEndDate() {
    return $this->expectedEndDate;
  }

  /**
   * Set hovNummer
   *
   * @param string $hovNummer
   * @return EindRapport
   */
  public function setHovNummer($hovNummer) {
    $this->hovNummer = $hovNummer;

    return $this;
  }

  /**
   * Get hovNummer
   *
   * @return string 
   */
  public function getHovNummer() {
    return $this->hovNummer;
  }

  /**
   * Set remarks
   *
   * @param string $remarks
   * @return EindRapport
   */
  public function setRemarks($remarks) {
    $this->remarks = $remarks;

    return $this;
  }

  /**
   * Get remarks
   *
   * @return string 
   */
  public function getRemarks() {
    return $this->remarks;
  }

  /**
   * Returns a new regel object which can be added the report
   * @return RapportRegelInterface
   */
  public function getNewRegelClass() {
    return new \CiviCoop\VragenboomBundle\Entity\EindRapportRegel();
  }

  /**
   * Add regels
   *
   * @param \CiviCoop\VragenboomBundle\Entity\EindRapportRegel $regels
   * @return EindRapport
   */
  public function addRegel(\CiviCoop\VragenboomBundle\Entity\RapportRegelInterface $regels) {
    $this->regels[] = $regels;

    return $this;
  }

  /**
   * Remove regels
   *
   * @param \CiviCoop\VragenboomBundle\Entity\EindRapportRegel $regels
   */
  public function removeRegel(\CiviCoop\VragenboomBundle\Entity\RapportRegelInterface $regels) {
    $this->regels->removeElement($regels);
  }

  /**
   * Get regels
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getRegels() {
    return $this->regels;
  }

  /**
   * Set activityId
   *
   * @param integer $activityId
   * @return EindRapport
   */
  public function setActivityId($activityId) {
    $this->activityId = $activityId;

    return $this;
  }

  /**
   * Get activityId
   *
   * @return integer 
   */
  public function getActivityId() {
    return $this->activityId;
  }

  /**
   * Set vgeNummer
   *
   * @param string $vgeNummer
   * @return EindRapport
   */
  public function setVgeNummer($vgeNummer) {
    $this->vgeNummer = $vgeNummer;

    return $this;
  }

  /**
   * Get vgeNummer
   *
   * @return string 
   */
  public function getVgeNummer() {
    return $this->vgeNummer;
  }

  /**
   * Set vgeAdres
   *
   * @param string $vgeAdres
   * @return EindRapport
   */
  public function setVgeAdres($vgeAdres) {
    $this->vgeAdres = $vgeAdres;

    return $this;
  }

  /**
   * Get vgeAdres
   *
   * @return string 
   */
  public function getVgeAdres() {
    return $this->vgeAdres;
  }

  /**
   * Set closed
   *
   * @param boolean $closed
   * @return EindRapport
   */
  public function setClosed($closed) {
    $this->closed = $closed;

    return $this;
  }

  /**
   * Get closed
   *
   * @return boolean 
   */
  public function isClosed() {
    return $this->closed;
  }

  /**
   * Get closed
   *
   * @return boolean 
   */
  public function getClosed() {
    return $this->closed;
  }

  /**
   * Add clients
   *
   * @param \CiviCoop\VragenboomBundle\Entity\Client $clients
   * @return EindRapport
   */
  public function addClient(\CiviCoop\VragenboomBundle\Entity\Client $clients) {
    $this->clients[] = $clients;

    return $this;
  }

  /**
   * Remove clients
   *
   * @param \CiviCoop\VragenboomBundle\Entity\Client $clients
   */
  public function removeClient(\CiviCoop\VragenboomBundle\Entity\Client $clients) {
    $this->clients->removeElement($clients);
  }

  /**
   * Get clients
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getClients() {
    return $this->clients;
  }

}
