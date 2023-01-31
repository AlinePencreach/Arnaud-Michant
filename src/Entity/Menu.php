<?php

namespace App\Entity;

use App\Entity\Formula;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    forceEager: false,
    normalizationContext: ['groups' => ['read:formulas', 'read:memus']]
)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:memus', 'read:formulas'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le menu doit contenir un titre")]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 255, minMessage: "Le titre doit faire au moins {{ limit }} caractères", maxMessage: "Le titre de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $title = null;

    #[Groups(['read:memus'])]
    #[ORM\ManyToMany(targetEntity: Formula::class, inversedBy: 'menus')]
    private Collection $formula;

    public function __construct()
    {
        $this->formula = new ArrayCollection();
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

    /**
     * @return Collection<int, Formula>
     */
    public function getFormula(): Collection
    {
        return $this->formula;
    }

    public function addFormula(Formula $formula): self
    {
        if (!$this->formula->contains($formula)) {
            $this->formula->add($formula);
        }

        return $this;
    }

    public function removeFormula(Formula $formula): self
    {
        $this->formula->removeElement($formula);

        return $this;
    }
}
