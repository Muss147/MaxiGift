<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Mapping\EntityBase;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RolesRepository")
 * @UniqueEntity(
 *     fields={"slug"},
 *     message="This slug is already in use."
 * )
 */
class Roles extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allAdminAccess = false;
    
    /**
     * @ORM\OneToMany(targetEntity=Permissions::class, mappedBy="role", cascade={"persist"})
     */
    private $permissions;

    /**
     * @ORM\OneToMany(targetEntity=Admins::class, mappedBy="roles", cascade={"persist"})
     */
    private $admins;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->admins = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Collection<int, Permissions>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permissions $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setRole($this);
        }

        return $this;
    }

    public function removePermission(Permissions $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getRole() === $this) {
                $permission->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Admins>
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admins $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
            $admin->setRoles($this);
        }

        return $this;
    }

    public function removeAdmin(Admins $admin): self
    {
        if ($this->admins->removeElement($admin)) {
            // set the owning side to null (unless already changed)
            if ($admin->getRoles() === $this) {
                $admin->setRoles(null);
            }
        }

        return $this;
    }

    public function isAllAdminAccess(): ?bool
    {
        return $this->allAdminAccess;
    }

    public function setAllAdminAccess(bool $allAdminAccess): self
    {
        $this->allAdminAccess = $allAdminAccess;

        return $this;
    }
}
