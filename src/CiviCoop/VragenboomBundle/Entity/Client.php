<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CiviCoop\VragenboomBundle\Entity\ClientRepository")
 */
class Client {
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
   * @ORM\Column(name="contactId", type="integer")
   */
  private $contactId;

  /**
   * @var string
   *
   * @ORM\Column(name="displayName", type="string", length=255)
   */
  private $displayName;

  /**
   * @var string
   *
   * @Assert\Email(message = "Enter a valid e-mail")
   *
   * @ORM\Column(name="email", type="string", length=255, nullable=true)
   */
  private $email;

  /**
   * @var string
   *
   * @ORM\Column(name="phone", type="string", length=255, nullable=true)
   */
  private $phone;

  /**
   * @var ToekomstAdres
   *
   * @ORM\OneToOne(targetEntity="ToekomstAdres", cascade={"all"}, orphanRemoval=true)
   */
  private $toekomstAdres;


  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set contactId
   *
   * @param string $contactId
   * @return Client
   */
  public function setContactId($contactId) {
    $this->contactId = $contactId;
    
    return $this;
  }

  /**
   * Get contactId
   *
   * @return string
   */
  public function getContactId() {
    return $this->contactId;
  }

  /**
   * Set displayName
   *
   * @param string $displayName
   * @return Client
   */
  public function setDisplayName($displayName) {
    $this->displayName = $displayName;
    
    return $this;
  }

  /**
   * Get displayName
   *
   * @return string
   */
  public function getDisplayName() {
    return $this->displayName;
  }

  /**
   * Get email address of client
   *
   * @return string
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Sets the email address of the client
   *
   * @param string $email
   * @return Client
   */
  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }

  /**
   * Get phone number of client
   *
   * @return string
   */
  public function getPhone() {
    return $this->phone;
  }

  /**
   * Sets the phone number of the client
   *
   * @param string $phone
   * @return Client
   */
  public function setPhone($phone) {
    $this->phone = $phone;
    return $this;
  }

  /**
   * @return \CiviCoop\VragenboomBundle\Entity\ToekomstAdres
   */
  public function getToekomstAdres() {
    return $this->toekomstAdres;
  }

  /**
   * @param \CiviCoop\VragenboomBundle\Entity\ToekomstAdres $toekomstAdres
   * @return Client
   */
  public function setToekomstAdres(ToekomstAdres $toekomstAdres) {
    $this->toekomstAdres = $toekomstAdres;
    return $this;
  }

  /**
   * @return Client
   */
  public function clearToekomstAdres() {
    $this->toekomstAdres = null;
    return $this;
  }
}