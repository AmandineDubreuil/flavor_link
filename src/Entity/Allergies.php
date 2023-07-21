<?php

namespace App\Entity;

use App\Repository\AllergiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AllergiesRepository::class)]
class Allergies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'allergies')]
    private ?Amis $ami = null;

    #[ORM\ManyToOne(inversedBy: 'allergies')]
    private ?Ingredients $ingredient = null;

    #[ORM\ManyToOne(inversedBy: 'allergies')]
    private ?CategoriesIngr $categorieIngredients = null;

    #[ORM\ManyToOne(inversedBy: 'allergies')]
    private ?SuperCategorieIngr $superCategorieIngr = null;

    public function getId(): ?int
    {
        return $this->id;
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
    // public function __toString(): string
    // {
    //     return $this->getIngredient();  // or some string field in your Vegetal Entity 
    // }

    public function getIngredient(): ?Ingredients
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredients $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getCategorieIngredients(): ?CategoriesIngr
    {
        return $this->categorieIngredients;
    }

    public function setCategorieIngredients(?CategoriesIngr $categorieIngredients): self
    {
        $this->categorieIngredients = $categorieIngredients;

        return $this;
    }

    public function getSuperCategorieIngr(): ?SuperCategorieIngr
    {
        return $this->superCategorieIngr;
    }

    public function setSuperCategorieIngr(?SuperCategorieIngr $superCategorieIngr): self
    {
        $this->superCategorieIngr = $superCategorieIngr;

        return $this;
    }
}
