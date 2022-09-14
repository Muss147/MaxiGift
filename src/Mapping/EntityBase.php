<?php

namespace App\Mapping;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class EntityBase
 *
 * PHP version 7.1
 *
 * LICENSE: MIT
 *
 * @package    AppBundle\Mapping
 * @author     Lelle - Daniele Rostellato <lelle.daniele@gmail.com>
 * @license    MIT
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 * @ORM\HasLifecycleCallbacks
 */
class EntityBase implements EntityBaseInterface
{
    /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Admins")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    protected $createdUser;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Admins")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    protected $updateUser;



    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() :void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null)
        {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt() :?DateTime
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt() :?DateTime
    {
        return $this->createdAt;
    }

 
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedUserstamps($currentUser) :void
    {
        $this->setUpdateUser($currentUser);

        if ($this->getCreatedUser() === null)
        {
            $this->setCreatedUser($currentUser);
        }
    }

    /**
     * Set createdUser
     * @return Admins
     */
    public function setCreatedUser($createdUser)
    {
        $this->createdUser = $createdUser;
        return $this;
    }

    /**
     * Get createdUser
     * @return App\Entity\Admins
     */
    public function getCreatedUser()
    {
        return $this->createdUser;
    }

    /**
     * Set updateUser
     * @param App\Entity\Admins $updateUser
     * @return Admins
     */
    public function setUpdateUser($updateUser = null)
    {
        $this->updateUser = $updateUser;
        return $this;
    }

    /**
     * Get updateUser
     * @return App\Entity\Admins
     */
    public function getUpdateUser()
    {
        return $this->updateUser;
    }

}