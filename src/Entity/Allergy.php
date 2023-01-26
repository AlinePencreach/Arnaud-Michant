<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AllergyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Persisters\Collection\ManyToManyPersister;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AllergyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:allergies']]
)]
class Allergy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups(['read:allergies'])]
    private ?int $id = null;

    #[Groups(['read:allergies', 'read:dishes', 'read:users'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'allergies')]
    private Collection $user;


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
