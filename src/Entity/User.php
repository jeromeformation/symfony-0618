<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="app_user")
 */
class User extends FOSUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\IdentityUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $identityUser;

    public function getId()
    {
        return $this->id;
    }

    public function getIdentityUser(): ?IdentityUser
    {
        return $this->identityUser;
    }

    public function setIdentityUser(IdentityUser $identityUser): self
    {
        $this->identityUser = $identityUser;

        return $this;
    }
}
