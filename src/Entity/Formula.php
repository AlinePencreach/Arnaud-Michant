<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Dishe;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormulaRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: FormulaRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['read:formulas']],
    denormalizationContext: ['groups' => ['write:formulas']]

)]
class Formula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[Groups(['read:formulas', 'write:formulas'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de formule est obligatoire")]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 255, minMessage: "Le nom doit faire au moins {{ limit }} caractères", maxMessage: "Le nom de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $title = null;

    #[Groups(['read:formulas', 'write:formulas'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 255, minMessage: "La description doit faire au moins {{ limit }} caractères", maxMessage: "La description de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $description = null;

    #[Groups(['read:formulas', 'write:formulas'])]
    #[ORM\Column]
    #[Assert\NotBlank(message: "Vous devez renseigner un prix pour cette formule")]
    #[Assert\Type(
        type: 'numeric',
        message: 'La valeur {{ value }} n\'est pas un {{ type }} valide.',
    )]
    private ?int $price = null;

    #[Groups(['read:formulas', 'write:formulas'])]
    #[ORM\ManyToMany(targetEntity: Dishe::class, inversedBy: 'formulas')]
    private Collection $dishes;

    #[Groups(['read:formulas', 'write:formulas'])]
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'formula')]
    private Collection $menus;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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
        }

        return $this;
    }

    public function removeDish(Dishe $dish): self
    {
        $this->dishes->removeElement($dish);

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->addFormula($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFormula($this);
        }

        return $this;
    }
}
