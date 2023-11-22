<?php

namespace App\Entity;

use App\Repository\BoughtComponentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoughtComponentRepository::class)]
class BoughtComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ActionsTaken = null;

    #[ORM\Column(length: 255)]
    private ?string $Manager = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Comment = null;

    #[ORM\ManyToOne(inversedBy: 'boughtComponents')]
    private ?EFNC $EFNC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionsTaken(): ?string
    {
        return $this->ActionsTaken;
    }

    public function setActionsTaken(string $ActionsTaken): static
    {
        $this->ActionsTaken = $ActionsTaken;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(?string $Comment): static
    {
        $this->Comment = $Comment;

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
}
