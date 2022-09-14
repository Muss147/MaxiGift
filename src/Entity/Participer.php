<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticiperRepository")
 */
class Participer extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = false;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Sondages", inversedBy="participants")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $sondage;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="participations")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSondage(): ?Sondages
    {
        return $this->sondage;
    }

    public function setSondage(?Sondages $sondage): self
    {
        $this->sondage = $sondage;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

}
