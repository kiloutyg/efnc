<?php

namespace App\Entity;

use App\Repository\EFNCRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EFNCRepository::class)]
class EFNC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Creator = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DetectionDate = null;

    #[ORM\Column(length: 255)]
    private ?string $Team = null;

    #[ORM\Column(length: 255)]
    private ?string $DetectionPlace = null;

    #[ORM\Column(length: 255)]
    private ?string $ProductDesignation = null;

    #[ORM\Column(length: 255)]
    private ?string $Project = null;

    #[ORM\Column(length: 255)]
    private ?string $UAP = null;

    #[ORM\Column(length: 255)]
    private ?string $NonConformityOrigin = null;

    #[ORM\Column]
    private ?int $Quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $AnomalyType = null;

    #[ORM\Column]
    private ?int $QuantityToBlock = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $DetailedDescription = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SAPReference = null;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: Picture::class)]
    private Collection $pictures;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: ImmediateConservatoryMeasures::class)]
    private Collection $immediateConservatoryMeasures;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: RiskWeighting::class)]
    private Collection $riskWeightings;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: BoughtComponent::class)]
    private Collection $boughtComponents;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: RootCausesAnalyse::class)]
    private Collection $rootCausesAnalyses;

    #[ORM\Column(nullable: true)]
    private ?bool $Status = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $ClosedDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PilotVisa = null;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->immediateConservatoryMeasures = new ArrayCollection();
        $this->riskWeightings = new ArrayCollection();
        $this->boughtComponents = new ArrayCollection();
        $this->rootCausesAnalyses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreator(): ?string
    {
        return $this->Creator;
    }

    public function setCreator(string $Creator): static
    {
        $this->Creator = $Creator;

        return $this;
    }

    public function getDetectionDate(): ?\DateTimeInterface
    {
        return $this->DetectionDate;
    }

    public function setDetectionDate(\DateTimeInterface $DetectionDate): static
    {
        $this->DetectionDate = $DetectionDate;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->Team;
    }

    public function setTeam(string $Team): static
    {
        $this->Team = $Team;

        return $this;
    }

    public function getDetectionPlace(): ?string
    {
        return $this->DetectionPlace;
    }

    public function setDetectionPlace(string $DetectionPlace): static
    {
        $this->DetectionPlace = $DetectionPlace;

        return $this;
    }

    public function getProductDesignation(): ?string
    {
        return $this->ProductDesignation;
    }

    public function setProductDesignation(string $ProductDesignation): static
    {
        $this->ProductDesignation = $ProductDesignation;

        return $this;
    }

    public function getProject(): ?string
    {
        return $this->Project;
    }

    public function setProject(string $Project): static
    {
        $this->Project = $Project;

        return $this;
    }

    public function getUAP(): ?string
    {
        return $this->UAP;
    }

    public function setUAP(string $UAP): static
    {
        $this->UAP = $UAP;

        return $this;
    }

    public function getNonConformityOrigin(): ?string
    {
        return $this->NonConformityOrigin;
    }

    public function setNonConformityOrigin(string $NonConformityOrigin): static
    {
        $this->NonConformityOrigin = $NonConformityOrigin;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): static
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getAnomalyType(): ?string
    {
        return $this->AnomalyType;
    }

    public function setAnomalyType(string $AnomalyType): static
    {
        $this->AnomalyType = $AnomalyType;

        return $this;
    }

    public function getQuantityToBlock(): ?int
    {
        return $this->QuantityToBlock;
    }

    public function setQuantityToBlock(int $QuantityToBlock): static
    {
        $this->QuantityToBlock = $QuantityToBlock;

        return $this;
    }

    public function getDetailedDescription(): ?string
    {
        return $this->DetailedDescription;
    }

    public function setDetailedDescription(string $DetailedDescription): static
    {
        $this->DetailedDescription = $DetailedDescription;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getSAPReference(): ?string
    {
        return $this->SAPReference;
    }

    public function setSAPReference(string $SAPReference): static
    {
        $this->SAPReference = $SAPReference;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setEFNC($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getEFNC() === $this) {
                $picture->setEFNC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImmediateConservatoryMeasures>
     */
    public function getImmediateConservatoryMeasures(): Collection
    {
        return $this->immediateConservatoryMeasures;
    }

    public function addImmediateConservatoryMeasure(ImmediateConservatoryMeasures $immediateConservatoryMeasure): static
    {
        if (!$this->immediateConservatoryMeasures->contains($immediateConservatoryMeasure)) {
            $this->immediateConservatoryMeasures->add($immediateConservatoryMeasure);
            $immediateConservatoryMeasure->setEFNC($this);
        }

        return $this;
    }

    public function removeImmediateConservatoryMeasure(ImmediateConservatoryMeasures $immediateConservatoryMeasure): static
    {
        if ($this->immediateConservatoryMeasures->removeElement($immediateConservatoryMeasure)) {
            // set the owning side to null (unless already changed)
            if ($immediateConservatoryMeasure->getEFNC() === $this) {
                $immediateConservatoryMeasure->setEFNC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RiskWeighting>
     */
    public function getRiskWeightings(): Collection
    {
        return $this->riskWeightings;
    }

    public function addRiskWeighting(RiskWeighting $riskWeighting): static
    {
        if (!$this->riskWeightings->contains($riskWeighting)) {
            $this->riskWeightings->add($riskWeighting);
            $riskWeighting->setEFNC($this);
        }

        return $this;
    }

    public function removeRiskWeighting(RiskWeighting $riskWeighting): static
    {
        if ($this->riskWeightings->removeElement($riskWeighting)) {
            // set the owning side to null (unless already changed)
            if ($riskWeighting->getEFNC() === $this) {
                $riskWeighting->setEFNC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoughtComponent>
     */
    public function getBoughtComponents(): Collection
    {
        return $this->boughtComponents;
    }

    public function addBoughtComponent(BoughtComponent $boughtComponent): static
    {
        if (!$this->boughtComponents->contains($boughtComponent)) {
            $this->boughtComponents->add($boughtComponent);
            $boughtComponent->setEFNC($this);
        }

        return $this;
    }

    public function removeBoughtComponent(BoughtComponent $boughtComponent): static
    {
        if ($this->boughtComponents->removeElement($boughtComponent)) {
            // set the owning side to null (unless already changed)
            if ($boughtComponent->getEFNC() === $this) {
                $boughtComponent->setEFNC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RootCausesAnalyse>
     */
    public function getRootCausesAnalyses(): Collection
    {
        return $this->rootCausesAnalyses;
    }

    public function addRootCausesAnalysis(RootCausesAnalyse $rootCausesAnalysis): static
    {
        if (!$this->rootCausesAnalyses->contains($rootCausesAnalysis)) {
            $this->rootCausesAnalyses->add($rootCausesAnalysis);
            $rootCausesAnalysis->setEFNC($this);
        }

        return $this;
    }

    public function removeRootCausesAnalysis(RootCausesAnalyse $rootCausesAnalysis): static
    {
        if ($this->rootCausesAnalyses->removeElement($rootCausesAnalysis)) {
            // set the owning side to null (unless already changed)
            if ($rootCausesAnalysis->getEFNC() === $this) {
                $rootCausesAnalysis->setEFNC(null);
            }
        }

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(?bool $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getClosedDate(): ?\DateTimeImmutable
    {
        return $this->ClosedDate;
    }

    public function setClosedDate(\DateTimeImmutable $ClosedDate): static
    {
        $this->ClosedDate = $ClosedDate;

        return $this;
    }

    public function getPilotVisa(): ?string
    {
        return $this->PilotVisa;
    }

    public function setPilotVisa(?string $PilotVisa): static
    {
        $this->PilotVisa = $PilotVisa;

        return $this;
    }
}