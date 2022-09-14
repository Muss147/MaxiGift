<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationsRepository")
 */
class Locations extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciblages", inversedBy="locations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $ciblage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(?string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getCiblage(): ?Ciblages
    {
        return $this->ciblage;
    }

    public function setCiblage(?Ciblages $ciblage): self
    {
        $this->ciblage = $ciblage;

        return $this;
    }

}
