<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    private ?File $file = null;

    #[ORM\Column(length: 255)]
    private ?string $Path = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?EFNC $EFNC = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    public function setFile(?File $file = null): void
    {
        $this->file = $file;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->Path;
    }

    public function setPath(string $Path): static
    {
        $this->Path = $Path;

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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }
}