<?php

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SlotRepository::class)
 */
class Slot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $slotBegin;

    /**
     * @ORM\Column(type="time")
     */
    private $slotEnd;

    /**
     * @ORM\ManyToMany(targetEntity=Teacher::class, mappedBy="availableSlots")
     */
    private $teachers;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="slot", orphanRemoval=true)
     */
    private $appointments;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlotBegin(): ?\DateTimeInterface
    {
        return $this->slotBegin;
    }

    public function setSlotBegin(\DateTimeInterface $slotBegin): self
    {
        $this->slotBegin = $slotBegin;

        return $this;
    }

    public function getSlotEnd(): ?\DateTimeInterface
    {
        return $this->slotEnd;
    }

    public function setSlotEnd(\DateTimeInterface $slotEnd): self
    {
        $this->slotEnd = $slotEnd;

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers[] = $teacher;
            $teacher->addAvailableSlot($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        if ($this->teachers->removeElement($teacher)) {
            $teacher->removeAvailableSlot($this);
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setSlot($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getSlot() === $this) {
                $appointment->setSlot(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getSlotBegin()->format("H:i") . " - " . $this->getSlotEnd()->format("H:i");
    }
}
