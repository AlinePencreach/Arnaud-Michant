<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DisheRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: DisheRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:dishes']]
)]
class Dishe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups(['read:dishes'])]
    private ?int $id = null;
    
    #[Groups(['read:dishes', 'read:formulas'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du plat est obligatoire")]
    #[Assert\Length(min: 3, max: 255, minMessage: "Le nom doit faire au moins {{ limit }} caractères", maxMessage: "Le nom de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $title = null;

    #[Groups(['read:dishes'])]
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 5, max: 255, minMessage: "La description doit faire au moins {{ limit }} caractères", maxMessage: "La description de ne peut pas dépasser {{ limit }} caractères")]
    private ?string $description = null;

    #[Groups(['read:dishes'])]
    #[ORM\Column]
    #[Assert\NotBlank(message: "Vous devez renseigner un prix pour ce plat")]
    #[Assert\Type(
        type: 'numeric',
        message: 'La valeur {{ value }} n\'est pas un {{ type }} valide.',
    )]
    private ?int $price = null;

    #[Groups(['read:dishes'])]
    #[ORM\ManyToMany(targetEntity: Allergy::class, inversedBy: 'dishes')]
    private Collection $allergies;

    #[ORM\ManyToMany(targetEntity: Formula::class, mappedBy: 'dishes')]
    private Collection $formulas;

    public function __construct()
    {
        $this->allergies = new ArrayCollection();
        $this->formulas = new ArrayCollection();
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
     * @return Collection<int, Allergy>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Allergy $allergy): self
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
        }

        return $this;
    }

    public function removeAllergy(Allergy $allergy): self
    {
        $this->allergies->removeElement($allergy);

        return $this;
    }

    /**
     * @return Collection<int, Formula>
     */
    public function getFormulas(): Collection
    {
        return $this->formulas;
    }

    public function addFormula(Formula $formula): self
    {
        if (!$this->formulas->contains($formula)) {
            $this->formulas->add($formula);
            $formula->addDish($this);
        }

        return $this;
    }

    public function removeFormula(Formula $formula): self
    {
        if ($this->formulas->removeElement($formula)) {
            $formula->removeDish($this);
        }

        return $this;
    }
}
