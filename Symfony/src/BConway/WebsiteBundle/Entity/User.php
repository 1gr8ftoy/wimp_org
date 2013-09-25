<?php

namespace BConway\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    private $signInCount;

    /**
     * @var \DateTime
     */
    private $currentSignInAt;

    /**
     * @var \DateTime
     */
    private $lastSignInAt;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


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
     * Set signInCount
     *
     * @param integer $signInCount
     * @return User
     */
    public function setSignInCount($signInCount)
    {
        $this->signInCount = $signInCount;
    
        return $this;
    }

    /**
     * Get signInCount
     *
     * @return integer 
     */
    public function getSignInCount()
    {
        return $this->signInCount;
    }

    /**
     * Set currentSignInAt
     *
     * @param \DateTime $currentSignInAt
     * @return User
     */
    public function setCurrentSignInAt($currentSignInAt)
    {
        $this->setLastSignInAt($this->getCurrentSignInAt());
        $this->currentSignInAt = $currentSignInAt;
    
        return $this;
    }

    /**
     * Get currentSignInAt
     *
     * @return \DateTime 
     */
    public function getCurrentSignInAt()
    {
        return $this->currentSignInAt;
    }

    /**
     * Set lastSignInAt
     *
     * @param \DateTime $lastSignInAt
     * @return User
     */
    public function setLastSignInAt($lastSignInAt)
    {
        $this->lastSignInAt = $lastSignInAt;
    
        return $this;
    }

    /**
     * Get lastSignInAt
     *
     * @return \DateTime 
     */
    public function getLastSignInAt()
    {
        return $this->lastSignInAt;
    }

    /**
     * Set createdAt
     *
     * @return User
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @return User
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lostPets;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $foundPets;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->lostPets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->foundPets = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add lostPets
     *
     * @param \BConway\WebsiteBundle\Entity\LostPet $lostPets
     * @return User
     */
    public function addLostPet(\BConway\WebsiteBundle\Entity\LostPet $lostPets)
    {
        $this->lostPets[] = $lostPets;
    
        return $this;
    }

    /**
     * Remove lostPets
     *
     * @param \BConway\WebsiteBundle\Entity\LostPet $lostPets
     */
    public function removeLostPet(\BConway\WebsiteBundle\Entity\LostPet $lostPets)
    {
        $this->lostPets->removeElement($lostPets);
    }

    /**
     * Get lostPets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLostPets()
    {
        return $this->lostPets;
    }

    /**
     * Add foundPets
     *
     * @param \BConway\WebsiteBundle\Entity\FoundPet $foundPets
     * @return User
     */
    public function addFoundPet(\BConway\WebsiteBundle\Entity\FoundPet $foundPets)
    {
        $this->foundPets[] = $foundPets;
    
        return $this;
    }

    /**
     * Remove foundPets
     *
     * @param \BConway\WebsiteBundle\Entity\FoundPet $foundPets
     */
    public function removeFoundPet(\BConway\WebsiteBundle\Entity\FoundPet $foundPets)
    {
        $this->foundPets->removeElement($foundPets);
    }

    /**
     * Get foundPets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFoundPets()
    {
        return $this->foundPets;
    }
}