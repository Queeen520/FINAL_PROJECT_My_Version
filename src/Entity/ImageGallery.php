<?php

namespace App\Entity;

use App\Repository\ImageGalleryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageGalleryRepository::class)]
class ImageGallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'imageGalleries')]
    private ?Course $fkCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getFkCourse(): ?Course
    {
        return $this->fkCourse;
    }

    public function setFkCourse(?Course $fkCourse): self
    {
        $this->fkCourse = $fkCourse;

        return $this;
    }
}
