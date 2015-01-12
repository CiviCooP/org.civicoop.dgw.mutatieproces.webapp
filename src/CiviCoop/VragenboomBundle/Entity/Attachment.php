<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attachment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Attachment
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
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="mimetype", type="string", length=255)
     */
    private $mimetype;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="blob")
     */
    private $content;


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
     * Set filename
     *
     * @param string $filename
     * @return Attachment
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set mimetype
     *
     * @param string $mimetype
     * @return Attachment
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    
        return $this;
    }

    /**
     * Get mimetype
     *
     * @return string 
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * Set content (base64 encoded)
     *
     * @param string $content
     * @return Attachment
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content (base64 encoded)
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Sets the raw content
     * @param blob $content
     * @return \CiviCoop\VragenboomBundle\Entity\Attachment
     */
    public function setRawContent($content) {
        $this->content = base64_encode($content);
        return $this;
    }
    
    /**
     * Returns the raw content
     * 
     * @return blob
     */
    public function getRawContent() {
        return base64_decode(stream_get_contents($this->content));
    }
}
