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

    #[ORM\Column(length: 255)]
    private ?string $Action = null;

    #[ORM\ManyToOne(inversedBy: 'immediateConservatoryMeasures')]
    private ?EFNC $EFNC = null;

    #[ORM\Column(length: 255)]
    private ?string $Manager = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $RealisedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?string
    {
        return $this->Action;
    }

    public function setAction(string $Action): static
    {
        $this->Action = $Action;

        return $this;
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
        return $this->Manager;
    }

    public function setManager(string $Manager): static
    {
        $this->Manager = $Manager;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getRealisedAt(): ?\DateTimeInterface
    {
        return $this->RealisedAt;
    }

    public function setRealisedAt(\DateTimeInterface $RealisedAt): static
    {
        $this->RealisedAt = $RealisedAt;

        return $this;
    }
}