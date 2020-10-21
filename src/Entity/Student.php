<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields="matricule", message="Ce matricule existe déja")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue
     *
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=25, nullable=false, unique=true)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $surname;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Serializer\Groups({"detail", "list"})
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

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

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        // Generate uuid
        $this->uuid = Uuid::uuid4()->toString();

        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
