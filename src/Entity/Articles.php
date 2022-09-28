<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Common\Collections\ArrayCollection;
use App\Mapping\EntityBase;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 *     fields={"sku"},
 *     message="This sku is already in use."
 * )
 */
class Articles extends EntityBase
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
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="boolean")
     */
    private $backorders = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Variantes", mappedBy="article", cascade={"persist"})
     */
    private $variantes;

    /**
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $remise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valeur_remise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poids;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $largeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hauteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longueur;

    /**
     * @ORM\Column(type="integer")
     */
    private $vues = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @var DateTime $publishAt
     *
     * @ORM\Column(name="publish_at", type="datetime", nullable=true)
     */
    protected $publishAt;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Files", mappedBy="article", cascade={"persist"})
    */
    private $medias;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Files", cascade={"persist"})
    */
    private $cover;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parametres", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parametres", inversedBy="articlesType", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marques", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $marque;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $tags = [];

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commandes", mappedBy="articles", cascade={"persist"})
     */
    private $commandes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->variantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
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
     * @return Collection<int, Commandes>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addArticle($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeArticle($this);
        }

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function isBackorders(): ?bool
    {
        return $this->backorders;
    }

    public function setBackorders(bool $backorders): self
    {
        $this->backorders = $backorders;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(string $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getLargeur(): ?string
    {
        return $this->largeur;
    }

    public function setLargeur(string $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?string
    {
        return $this->hauteur;
    }

    public function setHauteur(string $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getLongueur(): ?string
    {
        return $this->longueur;
    }

    public function setLongueur(string $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getPublishAt(): ?\DateTimeInterface
    {
        return $this->publishAt;
    }

    public function setPublishAt(?\DateTimeInterface $publishAt): self
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

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
     * @return Collection<int, Variantes>
     */
    public function getVariantes(): Collection
    {
        return $this->variantes;
    }

    public function addVariante(Variantes $variante): self
    {
        if (!$this->variantes->contains($variante)) {
            $this->variantes[] = $variante;
            $variante->setArticle($this);
        }

        return $this;
    }

    public function removeVariante(Variantes $variante): self
    {
        if ($this->variantes->removeElement($variante)) {
            // set the owning side to null (unless already changed)
            if ($variante->getArticle() === $this) {
                $variante->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Files>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Files $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setArticle($this);
        }

        return $this;
    }

    public function removeMedia(Files $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getArticle() === $this) {
                $media->setArticle(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Parametres
    {
        return $this->categorie;
    }

    public function setCategorie(?Parametres $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getType(): ?Parametres
    {
        return $this->type;
    }

    public function setType(?Parametres $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMarque(): ?Marques
    {
        return $this->marque;
    }

    public function setMarque(?Marques $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getValeurRemise(): ?string
    {
        return $this->valeur_remise;
    }

    public function setValeurRemise(string $valeur_remise): self
    {
        $this->valeur_remise = $valeur_remise;

        return $this;
    }

}
