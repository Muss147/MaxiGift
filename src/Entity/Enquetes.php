<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnquetesRepository")
 *     fields={"slug"},
 *     message="This slug is already in use."
 * )
 */
class Enquetes extends EntityBase
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $vues = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = false;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Files", cascade={"persist"})
    */
    private $cover;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questions", mappedBy="enquete", cascade={"remove"})
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conditions", mappedBy="enquete", cascade={"remove"})
     */
    private $conditions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InfoProfil", mappedBy="enquete", cascade={"remove"})
     */
    private $infoProfil;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    public function __construct()
    {
        $this->infoProfil = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conditions = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, InfoProfil>
     */
    public function getInfoProfil(): Collection
    {
        return $this->infoProfil;
    }

    public function addInfoProfil(InfoProfil $infoProfil): self
    {
        if (!$this->infoProfil->contains($infoProfil)) {
            $this->infoProfil[] = $infoProfil;
            $infoProfil->setEnquete($this);
        }

        return $this;
    }

    public function removeInfoProfil(InfoProfil $infoProfil): self
    {
        if ($this->infoProfil->removeElement($infoProfil)) {
            // set the owning side to null (unless already changed)
            if ($infoProfil->getEnquete() === $this) {
                $infoProfil->setEnquete(null);
            }
        }

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getVues(): ?int
    {
        return $this->vues;
    }

    public function setVues(int $vues): self
    {
        $this->vues = $vues;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?Files
    {
        return $this->cover;
    }

    public function setCover(?Files $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setEnquete($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getEnquete() === $this) {
                $question->setEnquete(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conditions>
     */
    public function getConditions(): Collection
    {
        return $this->conditions;
    }

    public function addCondition(Conditions $condition): self
    {
        if (!$this->conditions->contains($condition)) {
            $this->conditions[] = $condition;
            $condition->setEnquete($this);
        }

        return $this;
    }

    public function removeCondition(Conditions $condition): self
    {
        if ($this->conditions->removeElement($condition)) {
            // set the owning side to null (unless already changed)
            if ($condition->getEnquete() === $this) {
                $condition->setEnquete(null);
            }
        }

        return $this;
    }

}
