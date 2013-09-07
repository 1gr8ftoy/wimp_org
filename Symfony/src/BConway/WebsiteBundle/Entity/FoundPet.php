<?php

namespace BConway\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FoundPet
 */
class FoundPet
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
    private $petLocationFoundCity;

    /**
     * @var string
     */
    private $petLocationFoundState;

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
     * @return FoundPet
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
     * @return FoundPet
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
     * Set petColors
     *
     * @param string $petColors
     * @return FoundPet
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
     * @return FoundPet
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
     * Set petLocationFoundCity
     *
     * @param string $petLocationFoundCity
     * @return FoundPet
     */
    public function setPetLocationFoundCity($petLocationFoundCity)
    {
        $this->petLocationFoundCity = $petLocationFoundCity;
    
        return $this;
    }

    /**
     * Get petLocationFoundCity
     *
     * @return string 
     */
    public function getPetLocationFoundCity()
    {
        return $this->petLocationFoundCity;
    }

    /**
     * Set petLocationFoundState
     *
     * @param string $petLocationFoundState
     * @return FoundPet
     */
    public function setPetLocationFoundState($petLocationFoundState)
    {
        $this->petLocationFoundState = $petLocationFoundState;
    
        return $this;
    }

    /**
     * Get petLocationFoundState
     *
     * @return string 
     */
    public function getPetLocationFoundState()
    {
        return $this->petLocationFoundState;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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
     * @return FoundPet
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