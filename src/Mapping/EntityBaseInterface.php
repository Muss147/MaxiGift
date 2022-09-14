<?php

namespace App\Mapping;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * EntityBase Interface
 *
 * @author Lelle - Daniele Rostellato <lelle.daniele@gmail.com>
 */
interface EntityBaseInterface
{
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() :void;

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt() :?DateTime;

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt() :?DateTime;
}