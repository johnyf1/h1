<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alarm
 *
 * @ORM\Table(name="alarm")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlarmRepository")
 */
class Alarm
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
    /**
    * @ORM\ManyToOne(targetEntity="Customer")
    * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
    */
    private $customer;
        
    /**
     * @var string
     *
     * @ORM\Column(name="callId", type="string", length=255)
     */
    private $callId;
    
    
    /**
    * @ORM\ManyToOne(targetEntity="Operator", inversedBy="alarms")
    * @ORM\JoinColumn(name="operator_id", referencedColumnName="id")
    */
    private $operator;
    

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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Alarm
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
     * Set callId
     *
     * @param string $callId
     *
     * @return Alarm
     */
    public function setCallId($callId)
    {
        $this->callId = $callId;

        return $this;
    }

    /**
     * Get callId
     *
     * @return string
     */
    public function getCallId()
    {
        return $this->callId;
    }

    /**
     * Set operator
     *
     * @param \AppBundle\Entity\Operator $operator
     *
     * @return Alarm
     */
    public function setOperator(\AppBundle\Entity\Operator $operator = null)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return \AppBundle\Entity\Operator
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Alarm
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
}
