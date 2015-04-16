<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * ToekomstAdres
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ToekomstAdres {

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
   * @var integer
   *
   * @ORM\Column(name="civicrm_id", type="integer", nullable=true)
   */
  private $civicrm_id;

  /**
   * @var string
   *
   * @ORM\Column(name="street_address", type="string", length=255)
   */
  private $street_address;

  /**
   * @var string
   *
   * @ORM\Column(name="supplemental_address_1", type="string", length=255)
   */
  private $supplemental_address_1;

  /**
   * @var string
   *
   * @ORM\Column(name="city", type="string", length=255)
   */
  private $city;

  /**
   * @var string
   *
   * @ORM\Column(name="postal_code", type="string", length=255)
   */
  private $postal_code;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contactId
     *
     * @param integer $contactId
     * @return ToekomstAdres
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
    
        return $this;
    }

    /**
     * Get contactId
     *
     * @return integer 
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set civicrm_id
     *
     * @param integer $civicrmId
     * @return ToekomstAdres
     */
    public function setCivicrmId($civicrmId)
    {
        $this->civicrm_id = $civicrmId;
    
        return $this;
    }

    /**
     * Get civicrm_id
     *
     * @return integer 
     */
    public function getCivicrmId()
    {
        return $this->civicrm_id;
    }


    /**
     * Set supplemental_address_1
     *
     * @param string $supplementalAddress1
     * @return ToekomstAdres
     */
    public function setSupplementalAddress1($supplementalAddress1)
    {
        $this->supplemental_address_1 = $supplementalAddress1;
    
        return $this;
    }

    /**
     * Get supplemental_address_1
     *
     * @return string 
     */
    public function getSupplementalAddress1()
    {
        return $this->supplemental_address_1;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ToekomstAdres
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postal_code
     *
     * @param string $postalCode
     * @return ToekomstAdres
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;
    
        return $this;
    }

    /**
     * Get postal_code
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set street_address
     *
     * @param string $streetAddress
     * @return ToekomstAdres
     */
    public function setStreetAddress($streetAddress)
    {
        $this->street_address = $streetAddress;
    
        return $this;
    }

    /**
     * Get street_address
     *
     * @return string 
     */
    public function getStreetAddress()
    {
        return $this->street_address;
    }
}