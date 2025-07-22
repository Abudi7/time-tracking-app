<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TimeTrackingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeTrackingRepository::class)]
#[ApiResource]  // ← هذه هي السطر المطلوب
class TimeTracking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $endAt = null;
    

    #[ORM\Column(nullable: true)]
    private ?int $durationInMinutes = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startAt = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }
    

    public function setEndAt(?\DateTimeInterface $endAt): self
{
    $this->endAt = $endAt;

    return $this;
}

    

    public function getDurationInMinutes(): ?int
    {
        return $this->durationInMinutes;
    }

    public function setDurationInMinutes(?int $durationInMinutes): static
    {
        $this->durationInMinutes = $durationInMinutes;

        return $this;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
{
    $this->startAt = $startAt;

    return $this;
}


public function getStartAt(): ?\DateTimeInterface
{
    return $this->startAt;
}

}
