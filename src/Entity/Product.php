<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="75",
     *     minMessage="Le nom doit comporter minimum {{ limit }} caractères",
     *     maxMessage="Le nom doit comporter maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="1000",
     *     minMessage="La description doit comporter minimum {{ limit }} caractères",
     *     maxMessage="La description doit comporter maximum {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Type(type="float")
     * @Assert\Regex("/^\d{1,10}([.,]\d{1,2})?$/")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @Assert\Type(type="integer")
     * @Assert\Range(
     *     min="0",
     * )
     */
    private $nbViews;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $isPublished;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="products" ,cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * Product constructor.
     * @param bool $isPublished
     */
    public function __construct(bool $isPublished = true)
    {
        // On initialise les valeurs que l'on connait par avance
        $this->createdAt = new \Datetime();
        $this->nbViews = 0;
        // On initialise "isPublished"
        $this->isPublished = $isPublished;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNbViews(): ?int
    {
        return $this->nbViews;
    }

    public function setNbViews(int $nbViews): self
    {
        $this->nbViews = $nbViews;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
