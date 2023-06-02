<?php

namespace App\Entity;

use App\Repository\AllergiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergiesRepository::class)]
class Allergies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $ingredient = null;

    #[ORM\ManyToOne(inversedBy: 'allergies')]
    private ?Amis $ami = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function setIngredient(string $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getAmi(): ?Amis
    {
        return $this->ami;
    }

    public function setAmi(?Amis $ami): self
    {
        $this->ami = $ami;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getAmi();  // or some string field in your Vegetal Entity 
    }

}
