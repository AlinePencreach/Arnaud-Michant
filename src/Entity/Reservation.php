<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReservationRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:reservations']]
)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups(['read:reservations'])]
    private ?int $id = null;

    #[Groups(['read:reservations'])]
    #[ORM\Column]
    private ?int $guest_number = null;

    #[Groups(['read:reservations'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['read:reservations'])]
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[Groups(['read:reservations', 'read:users'])]
    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?Hourly $hourly = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuestNumber(): ?int
    {
        return $this->guest_number;
    }

    public function setGuestNumber(int $guest_number): self
    {
        $this->guest_number = $guest_number;

        return $this;
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


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getHourly(): ?Hourly
    {
        return $this->hourly;
    }

    public function setHourly(?Hourly $hourly): self
    {
        $this->hourly = $hourly;

        return $this;
    }
}
