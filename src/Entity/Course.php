<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Employee::class, mappedBy: 'courses')]
    private Collection $employees;

    #[ORM\ManyToMany(targetEntity: Trainer::class, mappedBy: 'courses')]
    private Collection $trainers;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->trainers = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }
    public function getDuration(): ?int { return $this->duration; }
    public function setDuration(?int $duration): static { $this->duration = $duration; return $this; }

    /** @return Collection<int, Employee> */
    public function getEmployees(): Collection { return $this->employees; }

    /** @return Collection<int, Trainer> */
    public function getTrainers(): Collection { return $this->trainers; }
}
