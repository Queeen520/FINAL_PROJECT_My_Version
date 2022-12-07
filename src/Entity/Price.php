<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'fkPrice', targetEntity: Course::class)]
    private Collection $courses;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'price', targetEntity: CourseCategory::class)]
    private Collection $fkCourseCategory;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->fkCourseCategory = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setFkPrice($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getFkPrice() === $this) {
                $course->setFkPrice(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CourseCategory>
     */
    public function getFkCourseCategory(): Collection
    {
        return $this->fkCourseCategory;
    }

    public function addFkCourseCategory(CourseCategory $fkCourseCategory): self
    {
        if (!$this->fkCourseCategory->contains($fkCourseCategory)) {
            $this->fkCourseCategory->add($fkCourseCategory);
            $fkCourseCategory->setPrice($this);
        }

        return $this;
    }

    public function removeFkCourseCategory(CourseCategory $fkCourseCategory): self
    {
        if ($this->fkCourseCategory->removeElement($fkCourseCategory)) {
            // set the owning side to null (unless already changed)
            if ($fkCourseCategory->getPrice() === $this) {
                $fkCourseCategory->setPrice(null);
            }
        }

        return $this;
    }
}
