<?php

namespace App\Entity;

use App\Repository\TopicsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TopicsRepository::class)
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields="name", message="Ce nom existe déja")
 */
class Topics
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
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $slug;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
