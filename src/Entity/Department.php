<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'datetime')]
    private $dataAjout;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Employer::class)]
    private $Employers;

    public function __construct()
    {
        $this->Employers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDataAjout(): ?\DateTimeInterface
    {
        return $this->dataAjout;
    }

    public function setDataAjout(\DateTimeInterface $dataAjout): self
    {
        $this->dataAjout = $dataAjout;

        return $this;
    }

    /**
     * @return Collection<int, Employer>
     */
    public function getEmployers(): Collection
    {
        return $this->Employers;
    }

    public function addEmployer(Employer $employer): self
    {
        if (!$this->Employers->contains($employer)) {
            $this->Employers[] = $employer;
            $employer->setDepartment($this);
        }

        return $this;
    }

    public function removeEmployer(Employer $employer): self
    {
        if ($this->Employers->removeElement($employer)) {
            // set the owning side to null (unless already changed)
            if ($employer->getDepartment() === $this) {
                $employer->setDepartment(null);
            }
        }

        return $this;
    }
}
