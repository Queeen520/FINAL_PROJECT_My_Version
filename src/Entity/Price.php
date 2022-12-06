<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceRepository::class)]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $studentPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $businessPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $privatePrice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentPrice(): ?string
    {
        return $this->studentPrice;
    }

    public function setStudentPrice(string $studentPrice): self
    {
        $this->studentPrice = $studentPrice;

        return $this;
    }

    public function getBusinessPrice(): ?string
    {
        return $this->businessPrice;
    }

    public function setBusinessPrice(string $businessPrice): self
    {
        $this->businessPrice = $businessPrice;

        return $this;
    }

    public function getPrivatePrice(): ?string
    {
        return $this->privatePrice;
    }

    public function setPrivatePrice(string $privatePrice): self
    {
        $this->privatePrice = $privatePrice;

        return $this;
    }
}
