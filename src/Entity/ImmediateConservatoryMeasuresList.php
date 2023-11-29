<?php

namespace App\Entity;

use App\Repository\ImmediateConservatoryMeasuresListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImmediateConservatoryMeasuresListRepository::class)]
class ImmediateConservatoryMeasuresList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'action', targetEntity: ImmediateConservatoryMeasures::class)]
    private Collection $immediateConservatoryMeasures;

    public function __construct()
    {
        $this->immediateConservatoryMeasures = new ArrayCollection();
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
            $immediateConservatoryMeasure->setAction($this);
        }

        return $this;
    }

    public function removeImmediateConservatoryMeasure(ImmediateConservatoryMeasures $immediateConservatoryMeasure): static
    {
        if ($this->immediateConservatoryMeasures->removeElement($immediateConservatoryMeasure)) {
            // set the owning side to null (unless already changed)
            if ($immediateConservatoryMeasure->getAction() === $this) {
                $immediateConservatoryMeasure->setAction(null);
            }
        }

        return $this;
    }
}