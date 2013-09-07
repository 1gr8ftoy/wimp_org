<?php

namespace BConway\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LostPet
 */
class LostPet
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $petType;

    /**
     * @var string
     */
    private $petName;

    /**
     * @var boolean
     */
    private $petComesWhenCalled;

    /**
     * @var string
     */
    private $petColors;

    /**
     * @var string
     */
    private $petDescription;

    /**
     * @var string
     */
    private $petHomeCity;

    /**
     * @var string
     */
    private $petHomeState;

    /**
     * @var string
     */
    private $petLocationLastSeen;

    /**
     * @var string
     */
    private $petMicrochip;

    /**
     * @var string
     */
    private $contactName;

    /**
     * @var string
     */
    private $contactEmail;

    /**
     * @var string
     */
    private $contactPhone;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $petImage;

    /**
     * @var string
     */
    private $petBreed;


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
     * Set petType
     *
     * @param string $petType
     * @return LostPet
     */
    public function setPetType($petType)
    {
        $this->petType = $petType;
    
        return $this;
    }

    /**
     * Get petType
     *
     * @return string 
     */
    public function getPetType()
    {
        return $this->petType;
    }

    /**
     * Set petName
     *
     * @param string $petName
     * @return LostPet
     */
    public function setPetName($petName)
    {
        $this->petName = $petName;
    
        return $this;
    }

    /**
     * Get petName
     *
     * @return string 
     */
    public function getPetName()
    {
        return $this->petName;
    }

    /**
     * Set petComesWhenCalled
     *
     * @param boolean $petComesWhenCalled
     * @return LostPet
     */
    public function setPetComesWhenCalled($petComesWhenCalled)
    {
        $this->petComesWhenCalled = $petComesWhenCalled;
    
        return $this;
    }

    /**
     * Get petComesWhenCalled
     *
     * @return boolean 
     */
    public function getPetComesWhenCalled()
    {
        return $this->petComesWhenCalled;
    }

    /**
     * Set petColors
     *
     * @param string $petColors
     * @return LostPet
     */
    public function setPetColors($petColors)
    {
        $this->petColors = $petColors;
    
        return $this;
    }

    /**
     * Get petColors
     *
     * @return string 
     */
    public function getPetColors()
    {
        return $this->petColors;
    }

    /**
     * Set petDescription
     *
     * @param string $petDescription
     * @return LostPet
     */
    public function setPetDescription($petDescription)
    {
        $this->petDescription = $petDescription;
    
        return $this;
    }

    /**
     * Get petDescription
     *
     * @return string 
     */
    public function getPetDescription()
    {
        return $this->petDescription;
    }

    /**
     * Set petHomeCity
     *
     * @param string $petHomeCity
     * @return LostPet
     */
    public function setPetHomeCity($petHomeCity)
    {
        $this->petHomeCity = $petHomeCity;
    
        return $this;
    }

    /**
     * Get petHomeCity
     *
     * @return string 
     */
    public function getPetHomeCity()
    {
        return $this->petHomeCity;
    }

    /**
     * Set petHomeState
     *
     * @param string $petHomeState
     * @return LostPet
     */
    public function setPetHomeState($petHomeState)
    {
        $this->petHomeState = $petHomeState;
    
        return $this;
    }

    /**
     * Get petHomeState
     *
     * @return string 
     */
    public function getPetHomeState()
    {
        return $this->petHomeState;
    }

    /**
     * Set petLocationLastSeen
     *
     * @param string $petLocationLastSeen
     * @return LostPet
     */
    public function setPetLocationLastSeen($petLocationLastSeen)
    {
        $this->petLocationLastSeen = $petLocationLastSeen;
    
        return $this;
    }

    /**
     * Get petLocationLastSeen
     *
     * @return string 
     */
    public function getPetLocationLastSeen()
    {
        return $this->petLocationLastSeen;
    }

    /**
     * Set petMicrochip
     *
     * @param string $petMicrochip
     * @return LostPet
     */
    public function setPetMicrochip($petMicrochip)
    {
        $this->petMicrochip = $petMicrochip;
    
        return $this;
    }

    /**
     * Get petMicrochip
     *
     * @return string 
     */
    public function getPetMicrochip()
    {
        return $this->petMicrochip;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     * @return LostPet
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    
        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     * @return LostPet
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    
        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     * @return LostPet
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    
        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string 
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return LostPet
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return LostPet
     */
    public function setCreatedAt($createdAt)
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
     * @return LostPet
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
     * Set petImage
     *
     * @param string $petImage
     * @return LostPet
     */
    public function setPetImage($petImage)
    {
        $this->petImage = $petImage;
    
        return $this;
    }

    /**
     * Get petImage
     *
     * @return string 
     */
    public function getPetImage()
    {
        return $this->petImage;
    }

    /**
     * Set petBreed
     *
     * @param string $petBreed
     * @return LostPet
     */
    public function setPetBreed($petBreed)
    {
        $this->petBreed = $petBreed;
    
        return $this;
    }

    /**
     * Get petBreed
     *
     * @return string 
     */
    public function getPetBreed()
    {
        return $this->petBreed;
    }
    /**
     * @var \BConway\WebsiteBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \BConway\WebsiteBundle\Entity\User $user
     * @return LostPet
     */
    public function setUser(\BConway\WebsiteBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \BConway\WebsiteBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}