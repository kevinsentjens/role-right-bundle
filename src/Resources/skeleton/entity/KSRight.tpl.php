<?php

namespace App\Entity;

use App\Repository\KSRightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KSRightRepository::class)
 */
class KSRight
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
    private $ks_right;

    /**
     * @ORM\ManyToMany(targetEntity=KSRole::class, mappedBy="ks_rights")
     */
    private $kSRoles;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $description;

    public function __construct()
    {
        $this->kSRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKsRight(): ?string
    {
        return $this->ks_right;
    }

    public function setKsRight(string $ks_right): self
    {
        $this->ks_right = $ks_right;

        return $this;
    }

    /**
     * @return Collection|KSRole[]
     */
    public function getKSRoles(): Collection
    {
        return $this->kSRoles;
    }

    public function addKSRole(KSRole $kSRole): self
    {
        if (!$this->kSRoles->contains($kSRole)) {
            $this->kSRoles[] = $kSRole;
            $kSRole->addKsRight($this);
        }

        return $this;
    }

    public function removeKSRole(KSRole $kSRole): self
    {
        if ($this->kSRoles->removeElement($kSRole)) {
            $kSRole->removeKsRight($this);
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
