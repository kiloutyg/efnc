<?php

namespace App\Entity;

use App\Repository\AnomalyTypeRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnomalyTypeRepository::class)]
#[UniqueEntity(fields: 'name', message: 'Le nom du type d\'Anomalie {{ value }} est déja utilisé.')]
class AnomalyType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(['type' => 'string'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'anomalyType', targetEntity: EFNC::class)]
    private Collection $eFNCs;

    #[ORM\Column(nullable: true)]
    private ?bool $archived = null;

    public function __construct()
    {
        $this->eFNCs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, EFNC>
     */
    public function getEFNCs(): Collection
    {
        return $this->eFNCs;
    }

    public function addEFNC(EFNC $eFNC): static
    {
        if (!$this->eFNCs->contains($eFNC)) {
            $this->eFNCs->add($eFNC);
            $eFNC->setAnomalyType($this);
        }

        return $this;
    }

    public function removeEFNC(EFNC $eFNC): static
    {
        if ($this->eFNCs->removeElement($eFNC)) {
            // set the owning side to null (unless already changed)
            if ($eFNC->getAnomalyType() === $this) {
                $eFNC->setAnomalyType(null);
            }
        }

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
}