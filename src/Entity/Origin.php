<?php

namespace App\Entity;

use App\Repository\OriginRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OriginRepository::class)]
#[UniqueEntity(fields: 'name', message: 'Le nom d\'Origine {{ value }} est déja utilisé.')]
class Origin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(['type' => 'string'])]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'nonConformityOrigin', targetEntity: EFNC::class)]
    private Collection $eFNCs;

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
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

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
            $eFNC->setNonConformityOrigin($this);
        }

        return $this;
    }

    public function removeEFNC(EFNC $eFNC): static
    {
        if ($this->eFNCs->removeElement($eFNC)) {
            // set the owning side to null (unless already changed)
            if ($eFNC->getNonConformityOrigin() === $this) {
                $eFNC->setNonConformityOrigin(null);
            }
        }

        return $this;
    }
}