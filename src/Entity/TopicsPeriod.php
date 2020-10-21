<?php

namespace App\Entity;

use App\Repository\TopicsPeriodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TopicsPeriodRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class TopicsPeriod
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Topics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $topics;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

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

    public function getTopics(): ?Topics
    {
        return $this->topics;
    }

    public function setTopics(?Topics $topics): self
    {
        $this->topics = $topics;

        return $this;
    }

    public function getPeriod(): ?Period
    {
        return $this->period;
    }

    public function setPeriod(?Period $period): self
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }
}
