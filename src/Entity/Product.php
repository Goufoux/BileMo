<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"product"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"product"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"product"})
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"product"})
     */
    private $screenDetails;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"product"})
     */
    private $camera_details;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"product"})
     */
    private $chip;

    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getScreenDetails(): ?string
    {
        return $this->screenDetails;
    }

    public function setScreenDetails(?string $screenDetails): self
    {
        $this->screenDetails = $screenDetails;

        return $this;
    }

    public function getCameraDetails(): ?string
    {
        return $this->camera_details;
    }

    public function setCameraDetails(?string $camera_details): self
    {
        $this->camera_details = $camera_details;

        return $this;
    }

    public function getChip(): ?string
    {
        return $this->chip;
    }

    public function setChip(?string $chip): self
    {
        $this->chip = $chip;

        return $this;
    }
}
