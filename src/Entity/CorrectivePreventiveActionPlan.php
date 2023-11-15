<?php

namespace App\Entity;

use App\Repository\CorrectivePreventiveActionPlanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorrectivePreventiveActionPlanRepository::class)]
class CorrectivePreventiveActionPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Deadline = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $CompletedOn = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Efficacity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->Deadline;
    }

    public function setDeadline(\DateTimeInterface $Deadline): static
    {
        $this->Deadline = $Deadline;

        return $this;
    }

    public function getCompletedOn(): ?\DateTimeInterface
    {
        return $this->CompletedOn;
    }

    public function setCompletedOn(?\DateTimeInterface $CompletedOn): static
    {
        $this->CompletedOn = $CompletedOn;

        return $this;
    }

    public function isEfficacity(): ?bool
    {
        return $this->Efficacity;
    }

    public function setEfficacity(?bool $Efficacity): static
    {
        $this->Efficacity = $Efficacity;

        return $this;
    }
}
