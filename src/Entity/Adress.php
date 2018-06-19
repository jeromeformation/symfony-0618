<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdressRepository")
 */
class Adress
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
    private $rue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\IdentityUser", mappedBy="adresses")
     */
    private $identityUsers;

    public function __construct()
    {
        $this->identityUsers = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * @return Collection|IdentityUser[]
     */
    public function getIdentityUsers(): Collection
    {
        return $this->identityUsers;
    }

    public function addIdentityUser(IdentityUser $identityUser): self
    {
        if (!$this->identityUsers->contains($identityUser)) {
            $this->identityUsers[] = $identityUser;
            $identityUser->addAdress($this);
        }

        return $this;
    }

    public function removeIdentityUser(IdentityUser $identityUser): self
    {
        if ($this->identityUsers->contains($identityUser)) {
            $this->identityUsers->removeElement($identityUser);
            $identityUser->removeAdress($this);
        }

        return $this;
    }
}
