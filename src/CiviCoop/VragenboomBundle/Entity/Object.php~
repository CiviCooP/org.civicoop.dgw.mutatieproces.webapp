<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Object
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CiviCoop\VragenboomBundle\Entity\ObjectRepository")
 */
class Object
{
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
     * @ORM\ManyToOne(targetEntity="Ruimte", inversedBy="objects")
     * @ORM\JoinColumn(name="ruimte_id", referencedColumnName="id")
     */
    protected $ruimte;
	
	/**
     * @Gedmo\Slug(fields={"naam"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
	
	/**
     * @ORM\OneToMany(targetEntity="ActieDefinitie", mappedBy="object")
     */
    protected $acties;
	
	public function __construct()
    {
        $this->acties = new ArrayCollection();
    }


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
     * Set naam
     *
     * @param string $naam
     * @return Object
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;
    
        return $this;
    }

    /**
     * Get naam
     *
     * @return string 
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * Set ruimte
     *
     * @param \CiviCoop\VragenboomBundle\Entity\Ruimte $ruimte
     * @return Object
     */
    public function setRuimte(\CiviCoop\VragenboomBundle\Entity\Ruimte $ruimte = null)
    {
        $this->ruimte = $ruimte;
    
        return $this;
    }

    /**
     * Get ruimte
     *
     * @return \CiviCoop\VragenboomBundle\Entity\Ruimte 
     */
    public function getRuimte()
    {
        return $this->ruimte;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add acties
     *
     * @param \CiviCoop\VragenboomBundle\Entity\ActieDefinitie $acties
     * @return Object
     */
    public function addActie(\CiviCoop\VragenboomBundle\Entity\ActieDefinitie $acties)
    {
        $this->acties[] = $acties;
    
        return $this;
    }

    /**
     * Remove acties
     *
     * @param \CiviCoop\VragenboomBundle\Entity\ActieDefinitie $acties
     */
    public function removeActie(\CiviCoop\VragenboomBundle\Entity\ActieDefinitie $acties)
    {
        $this->acties->removeElement($acties);
    }

    /**
     * Get acties
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActies()
    {
        return $this->acties;
    }
}