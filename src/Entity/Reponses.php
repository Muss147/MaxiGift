<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponsesRepository")
 */
class Reponses extends EntityBase
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
    private $libelle;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Files", cascade={"persist"})
    */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questions", inversedBy="reponses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getImage(): ?Files
    {
        return $this->image;
    }

    public function setImage(?Files $image): self
    {
        $this->image = $image;

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

}
