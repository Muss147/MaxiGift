<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This email is already in use."
 * )
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Files", cascade={"persist"})
    */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categorieSP;

    /**
     * @var DateTime $birth
     *
     * @ORM\Column(name="birth", type="datetime", nullable=true)
     */
    protected $birth;

    /**
     * @ORM\Column(type="integer")
     */
    private $points = 100;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activate = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
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
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InfoProfil", mappedBy="user", cascade={"remove"})
     */
    private $infoProfil;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participer", mappedBy="user", cascade={"remove"})
     */
    private $participations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeParainage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="parrain", cascade={"remove"})
     */
    private $filleuls;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="filleuls")
     * @ORM\JoinColumn(name="parrain_id", referencedColumnName="id", nullable=true)
     */
    private $parrain;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandes", mappedBy="user", cascade={"persist"})
     */
    private $commandes;

    /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Users")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    protected $createdUser;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Users")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    protected $updateUser;

    public function __construct()
    {
        $this->filleuls = new ArrayCollection();
        $this->infoProfil = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAvatar(): ?Files
    {
        return $this->avatar;
    }

    public function setAvatar(?Files $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() :void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null)
        {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedUserstamps($currentUser) :void
    {
        $this->setUpdateUser($currentUser);

        if ($this->getCreatedUser() === null)
        {
            $this->setCreatedUser($currentUser);
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedUser(): ?self
    {
        return $this->createdUser;
    }

    public function setCreatedUser(?self $createdUser): self
    {
        $this->createdUser = $createdUser;

        return $this;
    }

    public function getUpdateUser(): ?self
    {
        return $this->updateUser;
    }

    public function setUpdateUser(?self $updateUser): self
    {
        $this->updateUser = $updateUser;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(?\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

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

    /**
     * @return Collection<int, Users>
     */
    public function getFilleuls(): Collection
    {
        return $this->filleuls;
    }

    public function addFilleul(Users $filleul): self
    {
        if (!$this->filleuls->contains($filleul)) {
            $this->filleuls[] = $filleul;
            $filleul->setParrain($this);
        }

        return $this;
    }

    public function removeFilleul(Users $filleul): self
    {
        if ($this->filleuls->removeElement($filleul)) {
            // set the owning side to null (unless already changed)
            if ($filleul->getParrain() === $this) {
                $filleul->setParrain(null);
            }
        }

        return $this;
    }

    public function getParrain(): ?self
    {
        return $this->parrain;
    }

    public function setParrain(?self $parrain): self
    {
        $this->parrain = $parrain;

        return $this;
    }

    public function isActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

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
            $infoProfil->setUser($this);
        }

        return $this;
    }

    public function removeInfoProfil(InfoProfil $infoProfil): self
    {
        if ($this->infoProfil->removeElement($infoProfil)) {
            // set the owning side to null (unless already changed)
            if ($infoProfil->getUser() === $this) {
                $infoProfil->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participer>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participer $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setUser($this);
        }

        return $this;
    }

    public function removeParticipation(Participer $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUser() === $this) {
                $participation->setUser(null);
            }
        }

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
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getCategorieSP(): ?string
    {
        return $this->categorieSP;
    }

    public function setCategorieSP(?string $categorieSP): self
    {
        $this->categorieSP = $categorieSP;

        return $this;
    }

    public function getCodeParainage(): ?string
    {
        return $this->codeParainage;
    }

    public function setCodeParainage(?string $codeParainage): self
    {
        $this->codeParainage = $codeParainage;

        return $this;
    }
}
