<?php

namespace App\Entity;

use App\Repository\RecetteIngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteIngredientsRepository::class)]
class RecetteIngredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?Recettes $recetteId = null;

    #[ORM\ManyToOne(inversedBy: 'recetteIngredients')]
    private ?Ingredients $ingredientId = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(length: 255)]
    private ?string $uniteMesure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecetteId(): ?Recettes
    {
        return $this->recetteId;
    }

    public function setRecetteId(?Recettes $recetteId): self
    {
        $this->recetteId = $recetteId;

        return $this;
    }

    public function getIngredientId(): ?Ingredients
    {
        return $this->ingredientId;
    }

    public function setIngredientId(?Ingredients $ingredientId): self
    {
        $this->ingredientId = $ingredientId;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUniteMesure(): ?string
    {
        return $this->uniteMesure;
    }

    public function setUniteMesure(string $uniteMesure): self
    {
        $this->uniteMesure = $uniteMesure;

        return $this;
    }
}
