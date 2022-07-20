<?php

namespace App\Entity;

use App\Repository\PrimeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrimeRepository::class)]
class Prime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $prime;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $dateAjout;

    #[ORM\ManyToOne(targetEntity: Employer::class, inversedBy: 'primes')]
    private $Employers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrime(): ?float
    {
        return $this->prime;
    }

    public function setPrime(float $prime): self
    {
        $this->prime = $prime;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getEmployers(): ?Employer
    {
        return $this->Employers;
    }

    public function setEmployers(?Employer $Employers): self
    {
        $this->Employers = $Employers;

        return $this;
    }
}
