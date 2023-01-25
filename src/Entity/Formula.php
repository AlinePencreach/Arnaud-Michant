<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Dishe;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormulaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: FormulaRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:formulas']]
)]
class Formula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups(['read:formulas'])]
    private ?int $id = null;

    #[Groups(['read:formulas'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['read:formulas'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['read:formulas'])]
    #[ORM\Column]
    private ?int $price = null;

    #[Groups(['read:formulas'])]
    #[ORM\ManyToMany(targetEntity: Dishe::class, inversedBy: 'formulas')]
    private Collection $dishes;

    #[Groups(['read:formulas'])]
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
