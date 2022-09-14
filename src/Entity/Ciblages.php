<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CiblagesRepository")
 */
class Ciblages extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $sexe = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ageMini;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ageMaxi;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $categoriesSP = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastCmd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Locations", mappedBy="ciblage", cascade={"remove"})
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnquetesCibles", mappedBy="ciblage", cascade={"remove"})
     */
    private $cibles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parametres", inversedBy="ciblages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $typeCommande;

    public function __construct()
    {
        $this->locations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cibles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->typeCommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexe(): ?array
    {
        return $this->sexe;
    }

    public function setSexe(array $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAgeMini(): ?int
    {
        return $this->ageMini;
    }

    public function setAgeMini(int $ageMini): self
    {
        $this->ageMini = $ageMini;

        return $this;
    }

    public function getAgeMaxi(): ?int
    {
        return $this->ageMaxi;
    }

    public function setAgeMaxi(int $ageMaxi): self
    {
        $this->ageMaxi = $ageMaxi;

        return $this;
    }

    public function getCategoriesSP(): ?array
    {
        return $this->categoriesSP;
    }

    public function setCategoriesSP(array $categoriesSP): self
    {
        $this->categoriesSP = $categoriesSP;

        return $this;
    }

    /**
     * @return Collection<int, Locations>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Locations $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setCiblage($this);
        }

        return $this;
    }

    public function removeLocation(Locations $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getCiblage() === $this) {
                $location->setCiblage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EnquetesCibles>
     */
    public function getCibles(): Collection
    {
        return $this->cibles;
    }

    public function addCible(EnquetesCibles $cible): self
    {
        if (!$this->cibles->contains($cible)) {
            $this->cibles[] = $cible;
            $cible->setCiblage($this);
        }

        return $this;
    }

    public function removeCible(EnquetesCibles $cible): self
    {
        if ($this->cibles->removeElement($cible)) {
            // set the owning side to null (unless already changed)
            if ($cible->getCiblage() === $this) {
                $cible->setCiblage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parametres>
     */
    public function getTypeCommande(): Collection
    {
        return $this->typeCommande;
    }

    public function addTypeCommande(Parametres $typeCommande): self
    {
        if (!$this->typeCommande->contains($typeCommande)) {
            $this->typeCommande[] = $typeCommande;
        }

        return $this;
    }

    public function removeTypeCommande(Parametres $typeCommande): self
    {
        $this->typeCommande->removeElement($typeCommande);

        return $this;
    }

    public function getLastCmd(): ?string
    {
        return $this->lastCmd;
    }

    public function setLastCmd(string $lastCmd): self
    {
        $this->lastCmd = $lastCmd;

        return $this;
    }

}
