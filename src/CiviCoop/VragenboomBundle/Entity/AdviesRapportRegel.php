<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AdviesRapportRegel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CiviCoop\VragenboomBundle\Entity\AdviesRapportRegelRepository")
 */
class AdviesRapportRegel
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
     * @ORM\Column(name="remark", type="text", nullable=true)
     */
    private $remark;
	
	/**
     * @ORM\ManyToOne(targetEntity="AdviesRapport", inversedBy="regels")
     * @ORM\JoinColumn(name="adviesrapport_id", referencedColumnName="id")
     */
    protected $adviesRapport;
	
    /**
     * @ORM\ManyToOne(targetEntity="ActieDefinitie")
     * @ORM\JoinColumn(name="actiedefinitie_id", referencedColumnName="id")
     */
     protected $actie;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="verantwoordelijke", type="string", length=255)
     */
    protected $verantwoordelijke;

	public function __construct()
    {
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
     * Set remark
     *
     * @param string $remark
     * @return AdviesRapportRegel
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set adviesRapport
     *
     * @param \CiviCoop\VragenboomBundle\Entity\AdviesRapport $adviesRapport
     * @return AdviesRapportRegel
     */
    public function setAdviesRapport(\CiviCoop\VragenboomBundle\Entity\AdviesRapport $adviesRapport = null)
    {
        $this->adviesRapport = $adviesRapport;
    
        return $this;
    }

    /**
     * Get adviesRapport
     *
     * @return \CiviCoop\VragenboomBundle\Entity\AdviesRapport 
     */
    public function getAdviesRapport()
    {
        return $this->adviesRapport;
    }

    /**
     * Set actie
     *
     * @param \CiviCoop\VragenboomBundle\Entity\ActieDefinitie $actie
     * @return AdviesRapportRegel
     */
    public function setActie(\CiviCoop\VragenboomBundle\Entity\ActieDefinitie $actie = null)
    {
        $this->actie = $actie;
    
        return $this;
    }

    /**
     * Get actie
     *
     * @return \CiviCoop\VragenboomBundle\Entity\ActieDefinitie 
     */
    public function getActie()
    {
        return $this->actie;
    }

   /**
     * Set verantwoordelijke
     *
     * @param string $verantwoordelijke
     * @return ActieDefinitie
     */
    public function setVerantwoordelijke($verantwoordelijke)
    {
        $this->verantwoordelijke = $verantwoordelijke;
    
        return $this;
    }

    /**
     * Get verantwoordelijke
     *
     * @return string 
     */
    public function getVerantwoordelijke()
    {
        return $this->verantwoordelijke;
    }
}
