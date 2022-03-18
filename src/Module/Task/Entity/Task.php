<?php

namespace App\Module\Task\Entity;

use App\Module\Task\Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(name="tasks")
 */
class Task
{
    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSED = 'closed';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $sprintId;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $estimation;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSprintId(): ?string
    {
        return $this->sprintId;
    }

    public function setSprintId(string $sprintId): self
    {
        $this->sprintId = $sprintId;

        return $this;
    }

    public function getEstimation(): ?string
    {
        return $this->estimation;
    }

    public function setEstimation(string $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }
}
