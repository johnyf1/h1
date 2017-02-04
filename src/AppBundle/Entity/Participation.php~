<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParticipationRepository")
 */
class Participation
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
     * @ORM\Column(name="phoneNumber", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
   
    /**
     * @var bool
     *
     * @ORM\Column(name="participation", type="boolean")
     */
    private $participation;
    
    /**
    * @ORM\ManyToOne(targetEntity="Customer")
    * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
    */
    private $customer;
    
    /**
    * @ORM\ManyToOne(targetEntity="Firefighter")
    * @ORM\JoinColumn(name="firefighter_id", referencedColumnName="id")
    */
    private $firefighter;

    /**
    * @ORM\ManyToOne(targetEntity="Alarm")
    * @ORM\JoinColumn(name="alarm_id", referencedColumnName="id")
    */
    private $alarm;
    
    
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Participation
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Participation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Participation
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
     * Set firefighter
     *
     * @param \AppBundle\Entity\Firefighter $firefighter
     *
     * @return Participation
     */
    public function setFirefighter(\AppBundle\Entity\Firefighter $firefighter = null)
    {
        $this->firefighter = $firefighter;

        return $this;
    }

    /**
     * Get firefighter
     *
     * @return \AppBundle\Entity\Firefighter
     */
    public function getFirefighter()
    {
        return $this->firefighter;
    }

    /**
     * Set participation
     *
     * @param boolean $participation
     *
     * @return Participation
     */
    public function setParticipation($participation)
    {
        $this->participation = $participation;

        return $this;
    }

    /**
     * Get participation
     *
     * @return boolean
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * Set alarm
     *
     * @param \AppBundle\Entity\Alarm $alarm
     *
     * @return Participation
     */
    public function setAlarm(\AppBundle\Entity\Alarm $alarm = null)
    {
        $this->alarm = $alarm;

        return $this;
    }

    /**
     * Get alarm
     *
     * @return \AppBundle\Entity\Alarm
     */
    public function getAlarm()
    {
        return $this->alarm;
    }
}
