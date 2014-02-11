<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ruimte
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CiviCoop\VragenboomBundle\Entity\RuimteRepository")
 */
class Ruimte {

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
   * @Assert\NotBlank()
   * @ORM\Column(name="naam", type="string", length=255)
   */
  private $naam;

  /**
   * @Gedmo\Slug(fields={"naam"})
   * @ORM\Column(length=128, unique=true)
   */
  private $slug;

  /**
   * @var string

  /**
   * @ORM\ManyToMany(targetEntity="Object", mappedBy="ruimtes")
   * @ORM\OrderBy({"naam" = "ASC"})
   */
  protected $objects;

  public function __construct() {
    $this->objects = new ArrayCollection();
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
   * Set naam
   *
   * @param string $naam
   * @return ruimte
   */
  public function setNaam($naam) {
    $this->naam = $naam;

    return $this;
  }

  /**
   * Get naam
   *
   * @return string 
   */
  public function getNaam() {
    return $this->naam;
  }

  /**
   * Add objects
   *
   * @param \CiviCoop\VragenboomBundle\Entity\Object $objects
   * @return Ruimte
   */
  public function addObject(\CiviCoop\VragenboomBundle\Entity\Object $objects) {
    $this->objects[] = $objects;

    return $this;
  }

  /**
   * Remove objects
   *
   * @param \CiviCoop\VragenboomBundle\Entity\Object $objects
   */
  public function removeObject(\CiviCoop\VragenboomBundle\Entity\Object $objects) {
    $this->objects->removeElement($objects);
  }

  /**
   * Get objects
   *
   * @return \Doctrine\Common\Collections\Collection 
   */
  public function getObjects() {
    return $this->objects;
  }

  /**
   * Set slug
   *
   * @param string $slug
   * @return Ruimte
   */
  public function setSlug($slug) {
    $this->slug = $slug;

    return $this;
  }

  /**
   * Get slug
   *
   * @return string 
   */
  public function getSlug() {
    return $this->slug;
  }

}
