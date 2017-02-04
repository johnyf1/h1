<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer
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
     * @ORM\Column(name="customerName", type="string", length=255)
     */
    private $customerName;

    /**
     * @var int
     *
     * @ORM\Column(name="contractId", type="integer")
     */
    private $contractId;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSmsEnabled", type="boolean")
     */
    private $isSmsEnabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSmsSumarEnabled", type="boolean")
     */
    private $isSmsSumarEnabled;

    /**
     * @var string
     *
     * @ORM\Column(name="smsSumarNumbers", type="string", length=255)
     */
    private $smsSumarNumbers;
    
    
    /**
    * @ORM\OneToMany(targetEntity="Operator", mappedBy="customer")
    */
    private $operators; 
    
    /**
    * @ORM\OneToMany(targetEntity="Firefighter", mappedBy="customer")
    */
    private $firefighters; 

    /**
    * @ORM\OneToMany(targetEntity="Recording", mappedBy="customer")
    */
    private $recordings; 

    /**
    * @ORM\OneToMany(targetEntity="PhoneNumber", mappedBy="customer")
    */
    private $phoneNumbers;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="customer")
     */

    private $users;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operators = new \Doctrine\Common\Collections\ArrayCollection();
        $this->firefighters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recordings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phoneNumbers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Customer
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set contractId
     *
     * @param integer $contractId
     *
     * @return Customer
     */
    public function setContractId($contractId)
    {
        $this->contractId = $contractId;

        return $this;
    }

    /**
     * Get contractId
     *
     * @return integer
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * Set isSmsEnabled
     *
     * @param boolean $isSmsEnabled
     *
     * @return Customer
     */
    public function setIsSmsEnabled($isSmsEnabled)
    {
        $this->isSmsEnabled = $isSmsEnabled;

        return $this;
    }

    /**
     * Get isSmsEnabled
     *
     * @return boolean
     */
    public function getIsSmsEnabled()
    {
        return $this->isSmsEnabled;
    }

    /**
     * Set isSmsSumarEnabled
     *
     * @param boolean $isSmsSumarEnabled
     *
     * @return Customer
     */
    public function setIsSmsSumarEnabled($isSmsSumarEnabled)
    {
        $this->isSmsSumarEnabled = $isSmsSumarEnabled;

        return $this;
    }

    /**
     * Get isSmsSumarEnabled
     *
     * @return boolean
     */
    public function getIsSmsSumarEnabled()
    {
        return $this->isSmsSumarEnabled;
    }

    /**
     * Set smsSumarNumbers
     *
     * @param string $smsSumarNumbers
     *
     * @return Customer
     */
    public function setSmsSumarNumbers($smsSumarNumbers)
    {
        $this->smsSumarNumbers = $smsSumarNumbers;

        return $this;
    }

    /**
     * Get smsSumarNumbers
     *
     * @return string
     */
    public function getSmsSumarNumbers()
    {
        return $this->smsSumarNumbers;
    }

    /**
     * Add operator
     *
     * @param \AppBundle\Entity\Operator $operator
     *
     * @return Customer
     */
    public function addOperator(\AppBundle\Entity\Operator $operator)
    {
        $this->operators[] = $operator;

        return $this;
    }

    /**
     * Remove operator
     *
     * @param \AppBundle\Entity\Operator $operator
     */
    public function removeOperator(\AppBundle\Entity\Operator $operator)
    {
        $this->operators->removeElement($operator);
    }

    /**
     * Get operators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperators()
    {
        return $this->operators;
    }

    /**
     * Add firefighter
     *
     * @param \AppBundle\Entity\Firefighter $firefighter
     *
     * @return Customer
     */
    public function addFirefighter(\AppBundle\Entity\Firefighter $firefighter)
    {
        $this->firefighters[] = $firefighter;

        return $this;
    }

    /**
     * Remove firefighter
     *
     * @param \AppBundle\Entity\Firefighter $firefighter
     */
    public function removeFirefighter(\AppBundle\Entity\Firefighter $firefighter)
    {
        $this->firefighters->removeElement($firefighter);
    }

    /**
     * Get firefighters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirefighters()
    {
        return $this->firefighters;
    }

    /**
     * Add recording
     *
     * @param \AppBundle\Entity\Recording $recording
     *
     * @return Customer
     */
    public function addRecording(\AppBundle\Entity\Recording $recording)
    {
        $this->recordings[] = $recording;

        return $this;
    }

    /**
     * Remove recording
     *
     * @param \AppBundle\Entity\Recording $recording
     */
    public function removeRecording(\AppBundle\Entity\Recording $recording)
    {
        $this->recordings->removeElement($recording);
    }

    /**
     * Get recordings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecordings()
    {
        return $this->recordings;
    }

    /**
     * Add phoneNumber
     *
     * @param \AppBundle\Entity\PhoneNumber $phoneNumber
     *
     * @return Customer
     */
    public function addPhoneNumber(\AppBundle\Entity\PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers[] = $phoneNumber;

        return $this;
    }

    /**
     * Remove phoneNumber
     *
     * @param \AppBundle\Entity\PhoneNumber $phoneNumber
     */
    public function removePhoneNumber(\AppBundle\Entity\PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers->removeElement($phoneNumber);
    }

    /**
     * Get phoneNumbers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Customer
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
