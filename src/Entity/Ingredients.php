<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientsRepository::class)]
class Ingredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $groupe = null;

    #[ORM\Column(length: 255)]
    private ?string $sousGroupe = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredient = null;

    #[ORM\OneToMany(mappedBy: 'ingredientId', targetEntity: RecetteIngredients::class)]
    private Collection $recetteIngredients;

    public function __construct()
    {
        $this->recetteIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getSousGroupe(): ?string
    {
        return $this->sousGroupe;
    }

    public function setSousGroupe(string $sousGroupe): self
    {
        $this->sousGroupe = $sousGroupe;

        return $this;
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

    /**
     * @return Collection<int, RecetteIngredients>
     */
    public function __toString(): string
    {
        return $this->getIngredient();  // or some string field in your Vegetal Entity 
    }

    public function getRecetteIngredients(): Collection
    {
        return $this->recetteIngredients;
    }

    public function addRecetteIngredient(RecetteIngredients $recetteIngredient): self
    {
        if (!$this->recetteIngredients->contains($recetteIngredient)) {
            $this->recetteIngredients->add($recetteIngredient);
            $recetteIngredient->setIngredientId($this);
        }

        return $this;
    }

    public function removeRecetteIngredient(RecetteIngredients $recetteIngredient): self
    {
        if ($this->recetteIngredients->removeElement($recetteIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recetteIngredient->getIngredientId() === $this) {
                $recetteIngredient->setIngredientId(null);
            }
        }

        return $this;
    }
}
