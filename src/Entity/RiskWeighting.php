<?php

namespace App\Entity;

use App\Repository\RiskWeightingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RiskWeightingRepository::class)]
class RiskWeighting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column]
    private ?int $Weight = null;

    #[ORM\ManyToOne(inversedBy: 'riskWeightings')]
    private ?EFNC $EFNC = null;

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

    public function getWeight(): ?int
    {
        return $this->Weight;
    }

    public function setWeight(int $Weight): static
    {
        $this->Weight = $Weight;

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
