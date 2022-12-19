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

    #[ORM\ManyToOne(inversedBy: 'preBookings')]
    private ?Course $fkCourse = null;

    #[ORM\ManyToOne(inversedBy: 'preBookings')]
    private ?User $fkUser = null;

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

    public function getFkCourse(): ?Course
    {
        return $this->fkCourse;
    }

    public function setFkCourse(?Course $fkCourse): self
    {
        $this->fkCourse = $fkCourse;

        return $this;
    }

    public function getFkUser(): ?User
    {
        return $this->fkUser;
    }

    public function setFkUser(?User $fkUser): self
    {
        $this->fkUser = $fkUser;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    public function getGraduation(): ?string
    {
        return $this->graduation;
    }

    public function setGraduation(?string $graduation): self
    {
        $this->graduation = $graduation;

        return $this;
    }

}
