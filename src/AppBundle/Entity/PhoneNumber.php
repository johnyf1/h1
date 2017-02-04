<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhoneNumber
 *
 * @ORM\Table(name="phone_number")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhoneNumberRepository")
 */
class PhoneNumber
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
     * @var string
     *
     * @ORM\Column(name="trunkName", type="string", length=255)
     */
    private $trunkName;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="isPublic", type="boolean")
     */
    private $isPublic;
    
    
    /**
    * @ORM\ManyToOne(targetEntity="Customer", inversedBy="phoneNumbers")
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return PhoneNumber
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
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return PhoneNumber
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
     * Set trunkName
     *
     * @param string $trunkName
     *
     * @return PhoneNumber
     */
    public function setTrunkName($trunkName)
    {
        $this->trunkName = $trunkName;

        return $this;
    }

    /**
     * Get trunkName
     *
     * @return string
     */
    public function getTrunkName()
    {
        return $this->trunkName;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     *
     * @return PhoneNumber
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }
}
