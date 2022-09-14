<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PermissionsRepository")
 */
class Permissions extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lecture = false;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $ecriture = false;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $creation = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="permissions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $role;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Autorisations", inversedBy="permissions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $autorisation;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLecture(): ?bool
    {
        return $this->lecture;
    }

    public function setLecture(bool $lecture): self
    {
        $this->lecture = $lecture;

        return $this;
    }

    public function isEcriture(): ?bool
    {
        return $this->ecriture;
    }

    public function setEcriture(bool $ecriture): self
    {
        $this->ecriture = $ecriture;

        return $this;
    }

    public function isCreation(): ?bool
    {
        return $this->creation;
    }

    public function setCreation(bool $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAutorisation(): ?Autorisations
    {
        return $this->autorisation;
    }

    public function setAutorisation(?Autorisations $autorisation): self
    {
        $this->autorisation = $autorisation;

        return $this;
    }

}
