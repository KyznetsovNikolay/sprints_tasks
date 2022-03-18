<?php

namespace App\Module\Sprint\Entity;

use App\Module\Sprint\Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SprintRepository::class)
 * @ORM\Table(name="sprints")
 */
class Sprint
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
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $generatedId;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $week;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGeneratedId(): ?string
    {
        return $this->generatedId;
    }

    public function setGeneratedId(string $generatedId): self
    {
        $this->generatedId = $generatedId;

        return $this;
    }

    public function getWeek(): ?string
    {
        return $this->week;
    }

    public function setWeek(?string $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

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
