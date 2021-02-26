<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $abbreviation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Slot::class, inversedBy="teachers")
     */
    private $availableSlots;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="teacher", orphanRemoval=true)
     */
    private $appointments;

    public function __construct()
    {
        $this->availableSlots = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Slot[]
     */
    public function getAvailableSlots(): Collection
    {
        return $this->availableSlots;
    }

    public function addAvailableSlot(Slot $availableSlot): self
    {
        if (!$this->availableSlots->contains($availableSlot)) {
            $this->availableSlots[] = $availableSlot;
        }

        return $this;
    }

    public function removeAvailableSlot(Slot $availableSlot): self
    {
        $this->availableSlots->removeElement($availableSlot);

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
            $appointment->setTeacher($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getTeacher() === $this) {
                $appointment->setTeacher(null);
            }
        }

        return $this;
    }
}
