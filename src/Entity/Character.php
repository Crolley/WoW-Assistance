<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nameCharacter = null;

    #[ORM\Column(length: 255)]
    private ?string $raiderIo = null;

    #[ORM\Column(length: 255)]
    private ?string $server = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $player = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?Guild $guild = null;

    /**
     * @var Collection<int, EventParticipation>
     */
    #[ORM\OneToMany(targetEntity: EventParticipation::class, mappedBy: 'character')]
    private Collection $eventParticipations;

    /**
     * @var Collection<int, JoinRequest>
     */
    #[ORM\OneToMany(targetEntity: JoinRequest::class, mappedBy: 'character')]
    private Collection $joinRequests;

    /**
     * @var Collection<int, Loot>
     */
    #[ORM\OneToMany(targetEntity: Loot::class, mappedBy: 'character')]
    private Collection $loots;

    public function __construct()
    {
        $this->eventParticipations = new ArrayCollection();
        $this->joinRequests = new ArrayCollection();
        $this->loots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCharacter(): ?string
    {
        return $this->nameCharacter;
    }

    public function setNameCharacter(string $nameCharacter): static
    {
        $this->nameCharacter = $nameCharacter;

        return $this;
    }

    public function getRaiderIo(): ?string
    {
        return $this->raiderIo;
    }

    public function setRaiderIo(string $raiderIo): static
    {
        $this->raiderIo = $raiderIo;

        return $this;
    }

    public function getServer(): ?string
    {
        return $this->server;
    }

    public function setServer(string $server): static
    {
        $this->server = $server;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getPlayer(): ?user
    {
        return $this->player;
    }

    public function setPlayer(?user $player): static
    {
        $this->player = $player;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getGuild(): ?Guild
    {
        return $this->guild;
    }

    public function setGuild(?Guild $guild): static
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * @return Collection<int, EventParticipation>
     */
    public function getEventParticipations(): Collection
    {
        return $this->eventParticipations;
    }

    public function addEventParticipation(EventParticipation $eventParticipation): static
    {
        if (!$this->eventParticipations->contains($eventParticipation)) {
            $this->eventParticipations->add($eventParticipation);
            $eventParticipation->setCharacter($this);
        }

        return $this;
    }

    public function removeEventParticipation(EventParticipation $eventParticipation): static
    {
        if ($this->eventParticipations->removeElement($eventParticipation)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipation->getCharacter() === $this) {
                $eventParticipation->setCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JoinRequest>
     */
    public function getJoinRequests(): Collection
    {
        return $this->joinRequests;
    }

    public function addJoinRequest(JoinRequest $joinRequest): static
    {
        if (!$this->joinRequests->contains($joinRequest)) {
            $this->joinRequests->add($joinRequest);
            $joinRequest->setCharacter($this);
        }

        return $this;
    }

    public function removeJoinRequest(JoinRequest $joinRequest): static
    {
        if ($this->joinRequests->removeElement($joinRequest)) {
            // set the owning side to null (unless already changed)
            if ($joinRequest->getCharacter() === $this) {
                $joinRequest->setCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Loot>
     */
    public function getLoots(): Collection
    {
        return $this->loots;
    }

    public function addLoot(Loot $loot): static
    {
        if (!$this->loots->contains($loot)) {
            $this->loots->add($loot);
            $loot->setCharacter($this);
        }

        return $this;
    }

    public function removeLoot(Loot $loot): static
    {
        if ($this->loots->removeElement($loot)) {
            // set the owning side to null (unless already changed)
            if ($loot->getCharacter() === $this) {
                $loot->setCharacter(null);
            }
        }

        return $this;
    }
}
