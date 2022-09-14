<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SondagesRepository")
 * @UniqueEntity(
 *     fields={"slug"},
 *     message="This slug is already in use."
 * )
 */
class Sondages extends EntityBase
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
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant = 0;

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
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $paramEnvoi = [];

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Files", cascade={"persist"})
    */
    private $cover;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conditions", mappedBy="sondage", cascade={"remove"})
     */
    private $conditions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questions", mappedBy="sondage", cascade={"remove"})
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprises", inversedBy="sondages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $entreprise;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InfoProfil", mappedBy="sondage", cascade={"remove"})
     */
    private $participants;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ciblages", cascade={"remove"})
     */
    private $ciblage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conditions = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getEntreprise(): ?Entreprises
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprises $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, InfoProfil>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(InfoProfil $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setSondage($this);
        }

        return $this;
    }

    public function removeParticipant(InfoProfil $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getSondage() === $this) {
                $participant->setSondage(null);
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
            $question->setSondage($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getSondage() === $this) {
                $question->setSondage(null);
            }
        }

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
            $condition->setSondage($this);
        }

        return $this;
    }

    public function removeCondition(Conditions $condition): self
    {
        if ($this->conditions->removeElement($condition)) {
            // set the owning side to null (unless already changed)
            if ($condition->getSondage() === $this) {
                $condition->setSondage(null);
            }
        }

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

    public function getParamEnvoi(): ?array
    {
        return $this->paramEnvoi;
    }

    public function setParamEnvoi(array $paramEnvoi): self
    {
        $this->paramEnvoi = $paramEnvoi;

        return $this;
    }

}
