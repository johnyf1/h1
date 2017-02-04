<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operator
 *
 * @ORM\Table(name="operator")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperatorRepository")
 */
class Operator
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
     * @ORM\Column(name="fullName", type="string", length=255)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


    /**
    * @ORM\ManyToOne(targetEntity="Customer", inversedBy="operators")
    * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
    */
    private $customer;
    
    /**
    * @ORM\OneToMany(targetEntity="Alarm", mappedBy="operator")
    */
    private $alarms; 
    
    
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
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Operator
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Operator
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Operator
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Operator
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
     * Constructor
     */
    public function __construct()
    {
        $this->alarms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add alarm
     *
     * @param \AppBundle\Entity\Alarm $alarm
     *
     * @return Operator
     */
    public function addAlarm(\AppBundle\Entity\Alarm $alarm)
    {
        $this->alarms[] = $alarm;

        return $this;
    }

    /**
     * Remove alarm
     *
     * @param \AppBundle\Entity\Alarm $alarm
     */
    public function removeAlarm(\AppBundle\Entity\Alarm $alarm)
    {
        $this->alarms->removeElement($alarm);
    }

    /**
     * Get alarms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlarms()
    {
        return $this->alarms;
    }
}
