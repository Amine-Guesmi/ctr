<?php

namespace App\Entity;

use App\Repository\VoyageEffectuerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoyageEffectuerRepository::class)]
class VoyageEffectuer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $pointDebut;

    #[ORM\Column(type: 'datetime')]
    private $dateDebut;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pointFinale;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateFinale;

    #[ORM\ManyToOne(targetEntity: Chauffeur::class, inversedBy: 'voyageEffectuers')]
    private $Chauffeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPointDebut(): ?string
    {
        return $this->pointDebut;
    }

    public function setPointDebut(string $pointDebut): self
    {
        $this->pointDebut = $pointDebut;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getPointFinale(): ?string
    {
        return $this->pointFinale;
    }

    public function setPointFinale(?string $pointFinale): self
    {
        $this->pointFinale = $pointFinale;

        return $this;
    }

    public function getDateFinale(): ?\DateTimeInterface
    {
        return $this->dateFinale;
    }

    public function setDateFinale(?\DateTimeInterface $dateFinale): self
    {
        $this->dateFinale = $dateFinale;

        return $this;
    }

    public function getChauffeur(): ?Chauffeur
    {
        return $this->Chauffeur;
    }

    public function setChauffeur(?Chauffeur $Chauffeur): self
    {
        $this->Chauffeur = $Chauffeur;

        return $this;
    }
}
