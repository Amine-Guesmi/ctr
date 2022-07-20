<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $tel;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $cvFile;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Equipement::class)]
    private $equipements;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Chauffeur::class)]
    private $chauffeurs;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: SessionRecrutement::class)]
    private $sessionRecrutements;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Employer::class)]
    private $employers;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->chauffeurs = new ArrayCollection();
        $this->sessionRecrutements = new ArrayCollection();
        $this->employers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCvFile(): ?string
    {
        return $this->cvFile;
    }

    public function setCvFile(string $cvFile): self
    {
        $this->cvFile = $cvFile;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->setUser($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getUser() === $this) {
                $equipement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chauffeur>
     */
    public function getChauffeurs(): Collection
    {
        return $this->chauffeurs;
    }

    public function addChauffeur(Chauffeur $chauffeur): self
    {
        if (!$this->chauffeurs->contains($chauffeur)) {
            $this->chauffeurs[] = $chauffeur;
            $chauffeur->setUser($this);
        }

        return $this;
    }

    public function removeChauffeur(Chauffeur $chauffeur): self
    {
        if ($this->chauffeurs->removeElement($chauffeur)) {
            // set the owning side to null (unless already changed)
            if ($chauffeur->getUser() === $this) {
                $chauffeur->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SessionRecrutement>
     */
    public function getSessionRecrutements(): Collection
    {
        return $this->sessionRecrutements;
    }

    public function addSessionRecrutement(SessionRecrutement $sessionRecrutement): self
    {
        if (!$this->sessionRecrutements->contains($sessionRecrutement)) {
            $this->sessionRecrutements[] = $sessionRecrutement;
            $sessionRecrutement->setUser($this);
        }

        return $this;
    }

    public function removeSessionRecrutement(SessionRecrutement $sessionRecrutement): self
    {
        if ($this->sessionRecrutements->removeElement($sessionRecrutement)) {
            // set the owning side to null (unless already changed)
            if ($sessionRecrutement->getUser() === $this) {
                $sessionRecrutement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Employer>
     */
    public function getEmployers(): Collection
    {
        return $this->employers;
    }

    public function addEmployer(Employer $employer): self
    {
        if (!$this->employers->contains($employer)) {
            $this->employers[] = $employer;
            $employer->setUser($this);
        }

        return $this;
    }

    public function removeEmployer(Employer $employer): self
    {
        if ($this->employers->removeElement($employer)) {
            // set the owning side to null (unless already changed)
            if ($employer->getUser() === $this) {
                $employer->setUser(null);
            }
        }

        return $this;
    }
}
