<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnquetesCiblesRepository")
 */
class EnquetesCibles extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enquetes", inversedBy="cible", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $enquete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questions", inversedBy="cible", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $question;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Reponses", inversedBy="cibles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $reponses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciblages", inversedBy="cibles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $ciblage;

    public function __construct()
    {
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnquete(): ?Enquetes
    {
        return $this->enquete;
    }

    public function setEnquete(?Enquetes $enquete): self
    {
        $this->enquete = $enquete;

        return $this;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, Reponses>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponses $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): self
    {
        $this->reponses->removeElement($reponse);

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
