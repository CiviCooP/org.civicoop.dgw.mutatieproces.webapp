<?php

namespace CiviCoop\VragenboomBundle\Model;

use CiviCoop\VragenboomBundle\Entity\Client as ClientEntity;
use CiviCoop\VragenboomBundle\Entity\RapportInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 */
class Client {

  /**
   * @var ClientEntity
   */
  private $client;

  /**
   * @var RapportInterface
   */
  private $rapport;

  /**
   * @var string
   *
   * @Assert\Email(message = "Enter a valid e-mail")
   */
  private $email;

  public function __construct(ClientEntity $client, RapportInterface $rapport) {
    $this->client = $client;
    $this->rapport = $rapport;
  }

  public function getFutureAddress() {
    return $this->rapport->getFutureAddress();
  }

  public function setFutureAddress($futureAddress) {
    $this->rapport->setFutureAddress($futureAddress);
  }

  public function getClient() {
    return $this->client;
  }

  public function getRapport() {
    return $this->rapport;
  }


  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->client->getId();
  }

  /**
   * Set contactId
   *
   * @param string $contactId
   * @return Client
   */
  public function setContactId($contactId) {
    $this->client->setContactId($contactId);
    
    return $this;
  }

  /**
   * Get contactId
   *
   * @return string
   */
  public function getContactId() {
    return $this->client->getContactId();
  }

  /**
   * Set displayName
   *
   * @param string $displayName
   * @return Client
   */
  public function setDisplayName($displayName) {
    $this->client->setDisplayName($displayName);
    
    return $this;
  }

  /**
   * Get displayName
   *
   * @return string
   */
  public function getDisplayName() {
    return $this->client->getDisplayName();
  }

  /**
   * Get email address of client
   *
   * @return string
   */
  public function getEmail() {
    return $this->client->getEmail();
  }

  /**
   * Sets the email address of the client
   *
   * @param string $email
   * @return Client
   */
  public function setEmail($email) {
    $this->client->setEmail($email);
    $this->email = $email;
    return $this;
  }

  /**
   * Get phone number of client
   *
   * @return string
   */
  public function getPhone() {
    return $this->client->getPhone();
  }

  /**
   * Sets the phone number of the client
   *
   * @param string $phone
   * @return Client
   */
  public function setPhone($phone) {
    $this->client->setPhone($phone);
    return $this;
  }
}