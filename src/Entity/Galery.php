<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GaleryRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: GaleryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:galleries']]
)]
class Galery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:galleries'])]
    private ?int $id = null;

    #[Groups(['read:galleries'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'image doit comporter un titre'")]
    private ?string $title = null;

    #[Groups(['read:galleries'])]
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Vous devez importer un image")]
    private ?string $image = null;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
