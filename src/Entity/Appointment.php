<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Slot::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $slot;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $childName;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $childClass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlot(): ?Slot
    {
        return $this->slot;
    }

    public function setSlot(?Slot $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getChildName(): ?string
    {
        return $this->childName;
    }

    public function setChildName(?string $childName): self
    {
        $this->childName = $childName;

        return $this;
    }

    public function getChildClass(): ?string
    {
        return $this->childClass;
    }

    public function setChildClass(?string $childClass): self
    {
        $this->childClass = $childClass;

        return $this;
    }
}
