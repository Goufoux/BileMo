<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"user"})
     * @Assert\NotBlank(message="Veuillez saisir un prénom pour l'utilisateur")
     * @Assert\Length(
     *  min="3",
     *  max="50",
     *  minMessage="Le prénom est trop court il doit être composé d'au moins {{ limit }} caractères",
     *  maxMessage="Le prénom est trop grand il doit être composé de {{ limit }} caractères"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"user"})
     * @Assert\NotBlank(message="Veuillez saisir un nom pour l'utilisateur")
     * @Assert\Length(
     *  min="3",
     *  max="50",
     *  minMessage="Le nom est trop court il doit être composé d'au moins {{ limit }} caractères",
     *  maxMessage="Le nom est trop grand il doit être composé de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     * @Assert\NotBlank(message="Veuillez saisir une adresse email pour l'utilisateur")
     * @Assert\Email(message="L'adresse email ne semble pas valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     * @Assert\NotBlank(message="Veuillez saisir un mot de passe pour l'utilisateur")
     * @Assert\Length(
     *  min="8",
     *  minMessage="Le mot de passe est trop court il doit être composé d'au moins {{ limit }} caractères"
     * )
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
}
