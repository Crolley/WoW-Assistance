<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null; // ex: HM/MM

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guild $guild = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EventParticipation::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $eventParticipations;

    public function __construct()
    {
        $this->eventParticipations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
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

    public function getEventParticipations(): Collection
    {
        return $this->eventParticipations;
    }

    public function addEventParticipation(EventParticipation $participation): static
    {
        if (!$this->eventParticipations->contains($participation)) {
            $this->eventParticipations[] = $participation;
            $participation->setEvent($this);
        }

        return $this;
    }

    public function removeEventParticipation(EventParticipation $participation): static
    {
        if ($this->eventParticipations->removeElement($participation)) {
            if ($participation->getEvent() === $this) {
                $participation->setEvent(null);
            }
        }

        return $this;
    }

    public function getParticipationFor(Character $character): ?EventParticipation
    {
        foreach ($this->getEventParticipations() as $participation) {
            if ($participation->getCharacter() === $character) {
                return $participation;
            }
        }

        return null;
    }
}
