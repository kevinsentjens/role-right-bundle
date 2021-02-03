<?php

namespace App\Entity;

use App\Repository\KSRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KSRoleRepository::class)
 */
class KSRole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $ks_role;

    /**
     * @ORM\ManyToMany(targetEntity=KSRight::class, inversedBy="kSRoles")
     */
    private $ks_rights;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="ks_roles")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $description;

    public function __construct()
    {
        $this->ks_rights = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKsRole(): ?string
    {
        return $this->ks_role;
    }

    public function setKsRole(string $ks_role): self
    {
        $this->ks_role = $ks_role;

        return $this;
    }

    /**
     * @return Collection|KSRight[]
     */
    public function getKsRights(): Collection
    {
        return $this->ks_rights;
    }

    public function addKsRight(KSRight $ksRight): self
    {
        if (!$this->ks_rights->contains($ksRight)) {
            $this->ks_rights[] = $ksRight;
        }

        return $this;
    }

    public function removeKsRight(KSRight $ksRight): self
    {
        $this->ks_rights->removeElement($ksRight);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addKsRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeKsRole($this);
        }

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
}
