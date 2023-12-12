<?php

namespace App\Entity;

use App\Repository\TeamRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[UniqueEntity(fields: 'name', message: 'Le nom d\'équipe {{ value }} est déja utilisé.')]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Type(['type' => 'string'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: EFNC::class)]
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
            $eFNC->setTeam($this);
        }

        return $this;
    }

    public function removeEFNC(EFNC $eFNC): static
    {
        if ($this->eFNCs->removeElement($eFNC)) {
            // set the owning side to null (unless already changed)
            if ($eFNC->getTeam() === $this) {
                $eFNC->setTeam(null);
            }
        }

        return $this;
    }
}