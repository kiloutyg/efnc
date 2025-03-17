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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Creator = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DetectionDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $Quantity = null;

    #[ORM\Column(nullable: true)]
    private ?int $QuantityToBlock = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $DetailedDescription = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $UpdatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SAPReference = null;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: Picture::class)]
    private Collection $pictures;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: ImmediateConservatoryMeasures::class, cascade: ['persist', 'remove'])]
    private Collection $immediateConservatoryMeasures;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: BoughtComponent::class)]
    private Collection $boughtComponents;

    #[ORM\OneToMany(mappedBy: 'EFNC', targetEntity: RootCausesAnalyse::class)]
    private Collection $rootCausesAnalyses;

    #[ORM\Column(nullable: true)]
    private ?bool $Status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $ClosedDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Archiver = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DetectionTime = null;

    #[ORM\ManyToOne(inversedBy: 'eFNCs')]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'eFNCs')]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'eFNCs')]
    private ?UAP $uap = null;

    #[ORM\ManyToOne(inversedBy: 'eFNCs')]
    private ?Place $detectionPlace = null;

    #[ORM\ManyToOne(inversedBy: 'eFNCs')]
    private ?Origin $nonConformityOrigin = null;

    #[ORM\ManyToOne(inversedBy: 'eFNCs')]
    private ?AnomalyType $anomalyType = null;

    #[ORM\OneToOne(mappedBy: 'eFNC', cascade: ['persist', 'remove'])]
    private ?RiskWeighting $riskWeighting = null;

    #[ORM\OneToOne(mappedBy: 'EFNC', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?bool $archived = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastModifier = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $archivingCommentary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $closer = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $closingCommentary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $flag = null;


    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->immediateConservatoryMeasures = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): static
    {
        $this->Quantity = $Quantity;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->CreatedAt = new \DateTimeInterface();
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->UpdatedAt = new \DateTimeInterface();
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
        // If the status is set to true, we set the ClosedDate to the current date
        if ($Status === true) {
            $this->ClosedDate = new \DateTime();
        }
        return $this;
    }

    public function getClosedDate(): ?\DateTimeInterface
    {
        return $this->ClosedDate;
    }

    public function setClosedDate(\DateTimeInterface $ClosedDate): static
    {
        $this->ClosedDate = $ClosedDate;

        return $this;
    }

    public function getArchiver(): ?string
    {
        return $this->Archiver;
    }

    public function setArchiver(?string $Archiver): static
    {
        $this->Archiver = $Archiver;

        return $this;
    }

    public function getDetectionTime(): ?\DateTimeInterface
    {
        return $this->DetectionTime;
    }

    public function setDetectionTime(\DateTimeInterface $DetectionTime): static
    {
        $this->DetectionTime = $DetectionTime;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getUap(): ?UAP
    {
        return $this->uap;
    }

    public function setUap(?UAP $uap): static
    {
        $this->uap = $uap;

        return $this;
    }

    public function getDetectionPlace(): ?Place
    {
        return $this->detectionPlace;
    }

    public function setDetectionPlace(?Place $detectionPlace): static
    {
        $this->detectionPlace = $detectionPlace;

        return $this;
    }

    public function getNonConformityOrigin(): ?Origin
    {
        return $this->nonConformityOrigin;
    }

    public function setNonConformityOrigin(?Origin $nonConformityOrigin): static
    {
        $this->nonConformityOrigin = $nonConformityOrigin;

        return $this;
    }

    public function getAnomalyType(): ?AnomalyType
    {
        return $this->anomalyType;
    }

    public function setAnomalyType(?AnomalyType $anomalyType): static
    {
        $this->anomalyType = $anomalyType;

        return $this;
    }

    public function getRiskWeighting(): ?RiskWeighting
    {
        return $this->riskWeighting;
    }

    public function setRiskWeighting(?RiskWeighting $riskWeighting): static
    {
        // unset the owning side of the relation if necessary
        if ($riskWeighting === null && $this->riskWeighting !== null) {
            $this->riskWeighting->setEFNC(null);
        }

        // set the owning side of the relation if necessary
        if ($riskWeighting !== null && $riskWeighting->getEFNC() !== $this) {
            $riskWeighting->setEFNC($this);
        }

        $this->riskWeighting = $riskWeighting;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): static
    {
        // set the owning side of the relation if necessary
        if ($product->getEFNC() !== $this) {
            $product->setEFNC($this);
        }

        $this->product = $product;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }

    public function getLastModifier(): ?string
    {
        return $this->lastModifier;
    }

    public function setLastModifier(?string $lastModifier): static
    {
        $this->lastModifier = $lastModifier;

        return $this;
    }

    public function getArchivingCommentary(): ?string
    {
        return $this->archivingCommentary;
    }

    public function setArchivingCommentary(?string $archivingCommentary): static
    {
        $this->archivingCommentary = $archivingCommentary;

        return $this;
    }

    public function getCloser(): ?string
    {
        return $this->closer;
    }

    public function setCloser(?string $closer): static
    {
        $this->closer = $closer;

        return $this;
    }

    public function getClosingCommentary(): ?string
    {
        return $this->closingCommentary;
    }

    public function setClosingCommentary(?string $closingCommentary): static
    {
        $this->closingCommentary = $closingCommentary;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(?string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }
}
