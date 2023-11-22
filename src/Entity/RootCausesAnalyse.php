<?php

namespace App\Entity;

use App\Repository\RootCausesAnalyseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RootCausesAnalyseRepository::class)]
class RootCausesAnalyse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Comment = null;

    #[ORM\ManyToOne(inversedBy: 'rootCausesAnalyses')]
    private ?EFNC $EFNC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(string $Comment): static
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
