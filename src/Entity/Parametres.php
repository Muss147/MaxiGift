<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParametresRepository")
 */
class Parametres extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Files" , cascade={"persist"} )
    */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parametres", mappedBy="parent", cascade={"remove"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parametres", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entreprises", mappedBy="secteurActivite", cascade={"persist"})
     */
    private $entreprises;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="categorie", cascade={"persist"})
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="type", cascade={"persist"})
     */
    private $articlesType;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->entreprises = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->articlesType = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getImage(): ?Files
    {
        return $this->image;
    }

    public function setImage(?Files $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Parametres>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Parametres $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Parametres $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Entreprises>
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Entreprises $entreprise): self
    {
        if (!$this->entreprises->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setSecteurActivite($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprises $entreprise): self
    {
        if ($this->entreprises->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getSecteurActivite() === $this) {
                $entreprise->setSecteurActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticlesType(): Collection
    {
        return $this->articlesType;
    }

    public function addArticlesType(Articles $articlesType): self
    {
        if (!$this->articlesType->contains($articlesType)) {
            $this->articlesType[] = $articlesType;
            $articlesType->setType($this);
        }

        return $this;
    }

    public function removeArticlesType(Articles $articlesType): self
    {
        if ($this->articlesType->removeElement($articlesType)) {
            // set the owning side to null (unless already changed)
            if ($articlesType->getType() === $this) {
                $articlesType->setType(null);
            }
        }

        return $this;
    }
}
