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


    #[ORM\Column]
    private ?int $severityWeight = null;

    #[ORM\Column]
    private ?int $frequencyWeight = null;

    #[ORM\Column]
    private ?int $detectabilityWeight = null;

    #[ORM\Column]
    private ?int $RiskPriorityIndex = null;

    #[ORM\OneToOne(inversedBy: 'riskWeighting', cascade: ['persist', 'remove'])]
    private ?EFNC $eFNC = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSeverityWeight(): ?int
    {
        return $this->severityWeight;
    }

    public function setSeverityWeight(int $severityWeight): static
    {
        $this->severityWeight = $severityWeight;

        return $this;
    }

    public function getFrequencyWeight(): ?int
    {
        return $this->frequencyWeight;
    }

    public function setFrequencyWeight(int $frequencyWeight): static
    {
        $this->frequencyWeight = $frequencyWeight;

        return $this;
    }

    public function getDetectabilityWeight(): ?int
    {
        return $this->detectabilityWeight;
    }

    public function setDetectabilityWeight(int $detectabilityWeight): static
    {
        $this->detectabilityWeight = $detectabilityWeight;

        return $this;
    }

    public function getRiskPriorityIndex(): ?int
    {
        return $this->RiskPriorityIndex;
    }

    public function setRiskPriorityIndex(int $RiskPriorityIndex): static
    {
        $this->RiskPriorityIndex = $RiskPriorityIndex;

        return $this;
    }

    public function getEFNC(): ?EFNC
    {
        return $this->eFNC;
    }

    public function setEFNC(?EFNC $eFNC): static
    {
        $this->eFNC = $eFNC;

        return $this;
    }
}