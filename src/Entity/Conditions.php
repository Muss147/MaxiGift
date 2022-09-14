<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConditionsRepository")
 */
class Conditions extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Questions", cascade={"persist"})
    */
    private $question;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Reponses", cascade={"persist"})
    */
    private $reponse;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Questions", cascade={"persist"})
    */
    private $redirection;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enquetes", inversedBy="conditions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $enquete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sondages", inversedBy="conditions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $sondage;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReponse(): ?Reponses
    {
        return $this->reponse;
    }

    public function setReponse(?Reponses $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
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

    public function getRedirection(): ?Questions
    {
        return $this->redirection;
    }

    public function setRedirection(?Questions $redirection): self
    {
        $this->redirection = $redirection;

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

}
