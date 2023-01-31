<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use Doctrine\DBAL\Types\Type;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ReservationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['read:reservations']]
)]
class Reservation
{
   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:reservations', 'read:hourly'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: "Vous devez indiquer un nom pour la réservation")]
    #[Assert\Length(min: 3, max: 255, minMessage: "La description doit faire au moins {{ limit }} caractères", maxMessage: "La description de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $name = null;

    #[Groups(['read:reservations', 'read:hourly'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: "Vous devez indiquer lun numéro de téléphone pour la réservation")]
    #[Assert\Length(min: 3, max: 255, minMessage: "La description doit faire au moins {{ limit }} caractères", maxMessage: "La description de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $phoneNumber = null;

    #[Groups(['read:reservations', 'read:hourly'])]
    #[ORM\Column]
    #[Assert\NotBlank(message: "Vous devez indiquer le nombre de personne pour la réservation")]
    private ?int $guest_number = null;

    #[Groups(['read:reservations', 'read:hourly'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(min: 3, max: 255, minMessage: "La description doit faire au moins {{ limit }} caractères", maxMessage: "La description de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $description = null;

    #[Groups(['read:reservations', 'read:hourly'])]
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

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */ 
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */ 
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
