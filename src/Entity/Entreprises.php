<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntreprisesRepository")
 */
class Entreprises extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parametres", inversedBy="entreprises", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $secteurActivite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $registreCommerce;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fixe;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $email;

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
    * @ORM\OneToOne(targetEntity="App\Entity\Files", cascade={"persist"})
    */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $activate = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sondages", mappedBy="entreprise", cascade={"persist"})
     */
    private $sondages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admins", mappedBy="entreprise", cascade={"persist"})
     */
    private $responsables;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->sondages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->responsables = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRegistreCommerce(): ?string
    {
        return $this->registreCommerce;
    }

    public function setRegistreCommerce(?string $registreCommerce): self
    {
        $this->registreCommerce = $registreCommerce;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getFixe(): ?string
    {
        return $this->fixe;
    }

    public function setFixe(?string $fixe): self
    {
        $this->fixe = $fixe;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?Files
    {
        return $this->logo;
    }

    public function setLogo(?Files $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Sondages>
     */
    public function getSondages(): Collection
    {
        return $this->sondages;
    }

    public function addSondage(Sondages $sondage): self
    {
        if (!$this->sondages->contains($sondage)) {
            $this->sondages[] = $sondage;
            $sondage->setEntreprise($this);
        }

        return $this;
    }

    public function removeSondage(Sondages $sondage): self
    {
        if ($this->sondages->removeElement($sondage)) {
            // set the owning side to null (unless already changed)
            if ($sondage->getEntreprise() === $this) {
                $sondage->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Admins>
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Admins $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
            $responsable->setEntreprise($this);
        }

        return $this;
    }

    public function removeResponsable(Admins $responsable): self
    {
        if ($this->responsables->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getEntreprise() === $this) {
                $responsable->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getActivate(): ?string
    {
        return $this->activate;
    }

    public function setActivate(string $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function getNomContact(): ?string
    {
        return $this->nomContact;
    }

    public function setNomContact(?string $nomContact): self
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    public function getPrenomContact(): ?string
    {
        return $this->prenomContact;
    }

    public function setPrenomContact(?string $prenomContact): self
    {
        $this->prenomContact = $prenomContact;

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

    public function getSecteurActivite(): ?Parametres
    {
        return $this->secteurActivite;
    }

    public function setSecteurActivite(?Parametres $secteurActivite): self
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }
}
