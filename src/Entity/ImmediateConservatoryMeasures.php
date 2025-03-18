<?php

namespace App\Entity;

use App\Repository\ImmediateConservatoryMeasuresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImmediateConservatoryMeasuresRepository::class)]
class ImmediateConservatoryMeasures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'immediateConservatoryMeasures')]
    private ?EFNC $EFNC = null;

    #[ORM\Column(length: 255)]
    private ?string $manager = null;

    #[ORM\Column]
    private ?bool $done = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $realisedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customAction = null;

    #[ORM\ManyToOne(inversedBy: 'immediateConservatoryMeasures')]
    private ?ImmediateConservatoryMeasuresList $action = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEFNC(): ?EFNC
    {
        return $this->EFNC;
    }

    public function setEFNC(?EFNC $EFNC): static
    {
        $this->EFNC = $EFNC;

        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): static
    {
        $this->manager = $manager;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): static
    {
        $this->done = $done;

        return $this;
    }

    public function getRealisedAt(): ?\DateTimeInterface
    {
        return $this->realisedAt;
    }

    public function setRealisedAt(\DateTimeInterface $realisedAt): static
    {
        $this->realisedAt = $realisedAt;

        return $this;
    }

    public function getCustomAction(): ?string
    {
        return $this->customAction;
    }

    public function setCustomAction(?string $customAction): static
    {
        $this->customAction = $customAction;

        return $this;
    }

    public function getAction(): ?ImmediateConservatoryMeasuresList
    {
        return $this->action;
    }

    public function setAction(?ImmediateConservatoryMeasuresList $action): static
    {
        $this->action = $action;

        return $this;
    }
}