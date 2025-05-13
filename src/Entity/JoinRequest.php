<?php

namespace App\Entity;

use App\Repository\JoinRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoinRequestRepository::class)]
class JoinRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $submittedAt = null;

    #[ORM\ManyToOne(inversedBy: 'joinRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $character = null;

    #[ORM\ManyToOne(inversedBy: 'joinRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guild $guild = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTime
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(?\DateTime $submittedAt): static
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    public function setCharacter(?Character $character): static
    {
        $this->character = $character;

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
}
