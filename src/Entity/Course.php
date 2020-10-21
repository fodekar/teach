<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Course
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
     * @ORM\Column(type="string", length=10)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $hourStartAt;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Serializer\Groups({"detail", "list"})
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TopicsPeriod")
     * @ORM\JoinColumn(nullable=false)
     */
    private $topicsPeriod;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Student", cascade={"persist"})
     */
    private $student;

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
        $this->student = new ArrayCollection();
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

    public function getHourStartAt(): ?string
    {
        return $this->hourStartAt;
    }

    public function setHourStartAt(string $hourStartAt): self
    {
        $this->hourStartAt = $hourStartAt;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTopicsPeriod(): ?TopicsPeriod
    {
        return $this->topicsPeriod;
    }

    public function setTopicsPeriod(?TopicsPeriod $topicsPeriod): self
    {
        $this->topicsPeriod = $topicsPeriod;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->student->contains($student)) {
            $this->student[] = $student;
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->student->contains($student)) {
            $this->student->removeElement($student);
        }

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
