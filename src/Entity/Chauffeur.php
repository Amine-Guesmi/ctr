<?php

namespace App\Entity;

use App\Repository\ChauffeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChauffeurRepository::class)]
class Chauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'integer')]
    private $tel;

    #[ORM\Column(type: 'text', nullable: true)]
    private $image;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'chauffeurs')]
    private $User;

    #[ORM\OneToMany(mappedBy: 'Chauffeur', targetEntity: VoyageEffectuer::class)]
    private $voyageEffectuers;

    public function __construct()
    {
        $this->voyageEffectuers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, VoyageEffectuer>
     */
    public function getVoyageEffectuers(): Collection
    {
        return $this->voyageEffectuers;
    }

    public function addVoyageEffectuer(VoyageEffectuer $voyageEffectuer): self
    {
        if (!$this->voyageEffectuers->contains($voyageEffectuer)) {
            $this->voyageEffectuers[] = $voyageEffectuer;
            $voyageEffectuer->setChauffeur($this);
        }

        return $this;
    }

    public function removeVoyageEffectuer(VoyageEffectuer $voyageEffectuer): self
    {
        if ($this->voyageEffectuers->removeElement($voyageEffectuer)) {
            // set the owning side to null (unless already changed)
            if ($voyageEffectuer->getChauffeur() === $this) {
                $voyageEffectuer->setChauffeur(null);
            }
        }

        return $this;
    }
}
