<?php

namespace App\Entity;

use App\Repository\PreBookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreBookingRepository::class)]
class PreBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numberParticipants = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $review = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberParticipants(): ?int
    {
        return $this->numberParticipants;
    }

    public function setNumberParticipants(int $numberParticipants): self
    {
        $this->numberParticipants = $numberParticipants;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(?string $review): self
    {
        $this->review = $review;

        return $this;
    }
}
