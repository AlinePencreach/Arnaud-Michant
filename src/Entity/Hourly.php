<?php

namespace App\Entity;

use App\Entity\Reservation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HourlyRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: HourlyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:hourly']],
    operations: [
        new GetCollection(),
        new Post()
    ]
)]

class Hourly
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Groups(['read:hourly', 'read:reservations', 'read:users', 'write:hourly'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\Date]
    private ?\DateTimeInterface $date = null;

    #[Groups(['read:hourly', 'read:reservations', 'read:users', 'write:hourly'])]
    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
     /**
     * @var string A "H:i" formatted value
     */
    #[Assert\Time]
    private ?\DateTimeInterface $hour = null;

    #[Groups(['read:hourly', 'write:hourly'])]
    #[ORM\Column(nullable: true)]
    #[Assert\Type(
        type: 'numeric',
        message: 'La valeur {{ value }} n\'est pas un {{ type }} valide.',
    )]
    private ?int $host_limit = null;


    #[Groups(['read:hourly'])]
    #[ORM\OneToMany(mappedBy: 'hourly', targetEntity: Reservation::class)]
    private Collection $reservation;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(?\DateTimeInterface $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getHostLimit(): ?int
    {
        $host_limit = $this->host_limit;
        // guarantee host_limit is 50
        $host_limit[] = 50;

        return $this->host_limit;
    }

    public function setHostLimit(?int $host_limit): self
    {
        $this->host_limit = $host_limit;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setHourly($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHourly() === $this) {
                $reservation->setHourly(null);
            }
        }

        return $this;
    }
}
