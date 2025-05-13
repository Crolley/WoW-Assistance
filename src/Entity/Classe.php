<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rolePrincipal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'classe')]
    private Collection $characters;

    /**
     * @var Collection<int, Specialisation>
     */
    #[ORM\OneToMany(targetEntity: Specialisation::class, mappedBy: 'classe')]
    private Collection $specialisations;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->specialisations = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getRolePrincipal(): ?string
    {
        return $this->rolePrincipal;
    }

    public function setRolePrincipal(?string $rolePrincipal): static
    {
        $this->rolePrincipal = $rolePrincipal;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setClasse($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getClasse() === $this) {
                $character->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Specialisation>
     */
    public function getSpecialisations(): Collection
    {
        return $this->specialisations;
    }

    public function addSpecialisation(Specialisation $specialisation): static
    {
        if (!$this->specialisations->contains($specialisation)) {
            $this->specialisations->add($specialisation);
            $specialisation->setClasse($this);
        }

        return $this;
    }

    public function removeSpecialisation(Specialisation $specialisation): static
    {
        if ($this->specialisations->removeElement($specialisation)) {
            // set the owning side to null (unless already changed)
            if ($specialisation->getClasse() === $this) {
                $specialisation->setClasse(null);
            }
        }

        return $this;
    }
}
