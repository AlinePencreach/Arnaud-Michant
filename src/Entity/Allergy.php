<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Dishe;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AllergyRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AllergyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['read:allergies']],
    denormalizationContext: ['groups' => ['write:allergies']]
)]
class Allergy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[Groups(['read:allergies', 'write:allergies', 'read:dishes', 'write:dishes', 'read:users'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'allergie est obligatoire")]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 255, minMessage: "Le nom doit faire au moins {{ limit }} caractères", maxMessage: "Le nom de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $name = null;


    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'allergies')]
    private Collection $user;


    #[Groups(['write:allergies'])]
    #[ORM\ManyToMany(targetEntity: Dishe::class, mappedBy: 'allergies')]
    private Collection $dishes;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Dishe>
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dishe $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->addAllergy($this);
        }

        return $this;
    }

    public function removeDish(Dishe $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            $dish->removeAllergy($this);
        }

        return $this;
    }
}
