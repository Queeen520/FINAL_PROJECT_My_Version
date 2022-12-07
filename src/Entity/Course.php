<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?CourseCategory $fkCourseCategory = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?Price $fkPrice = null;

    #[ORM\OneToMany(mappedBy: 'fkCourse', targetEntity: ImageGallery::class)]
    private Collection $imageGalleries;

    #[ORM\OneToMany(mappedBy: 'fkCourse', targetEntity: PreBooking::class)]
    private Collection $preBookings;

    public function __construct()
    {
        $this->imageGalleries = new ArrayCollection();
        $this->preBookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getFkCourseCategory(): ?CourseCategory
    {
        return $this->fkCourseCategory;
    }

    public function setFkCourseCategory(?CourseCategory $fkCourseCategory): self
    {
        $this->fkCourseCategory = $fkCourseCategory;

        return $this;
    }

    public function getFkPrice(): ?Price
    {
        return $this->fkPrice;
    }

    public function setFkPrice(?Price $fkPrice): self
    {
        $this->fkPrice = $fkPrice;

        return $this;
    }

    /**
     * @return Collection<int, ImageGallery>
     */
    public function getImageGalleries(): Collection
    {
        return $this->imageGalleries;
    }

    public function addImageGallery(ImageGallery $imageGallery): self
    {
        if (!$this->imageGalleries->contains($imageGallery)) {
            $this->imageGalleries->add($imageGallery);
            $imageGallery->setFkCourse($this);
        }

        return $this;
    }

    public function removeImageGallery(ImageGallery $imageGallery): self
    {
        if ($this->imageGalleries->removeElement($imageGallery)) {
            // set the owning side to null (unless already changed)
            if ($imageGallery->getFkCourse() === $this) {
                $imageGallery->setFkCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PreBooking>
     */
    public function getPreBookings(): Collection
    {
        return $this->preBookings;
    }

    public function addPreBooking(PreBooking $preBooking): self
    {
        if (!$this->preBookings->contains($preBooking)) {
            $this->preBookings->add($preBooking);
            $preBooking->setFkCourse($this);
        }

        return $this;
    }

    public function removePreBooking(PreBooking $preBooking): self
    {
        if ($this->preBookings->removeElement($preBooking)) {
            // set the owning side to null (unless already changed)
            if ($preBooking->getFkCourse() === $this) {
                $preBooking->setFkCourse(null);
            }
        }

        return $this;
    }
}
