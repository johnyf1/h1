<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * recording
 *
 * @ORM\Table(name="recording")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecordingRepository")
 */
class Recording
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="recordingName", type="string", length=255)
     * @Assert\NotBlank(message="Please upload a valid WAV file.")
     * @Assert\File(
     *     maxSize = "1024k",
     *     )
     */
//     mimeTypes={ "audio" }
    private $recordingName;


    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDefault", type="boolean")
     */
    private $isDefault = 0;

    /**
    * @ORM\ManyToOne(targetEntity="Customer", inversedBy="recordings")
    * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
    */
    private $customer;
    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set recordingName
     *
     * @param string $recordingName
     *
     * @return recording
     */
    public function setRecordingName($recordingName)
    {
        $this->recordingName = $recordingName;

        return $this;
    }

    /**
     * Get recordingName
     *
     * @return string
     */
    public function getRecordingName()
    {
        return $this->recordingName;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return recording
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Recording
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     *
     * @return Recording
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }
}
