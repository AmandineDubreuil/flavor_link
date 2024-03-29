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
    private ?string $ingredient = null;

    #[ORM\OneToMany(mappedBy: 'ingredientId', targetEntity: RecetteIngredients::class)]
    private Collection $recetteIngredients;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?CategoriesIngr $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: Allergies::class)]
    private Collection $allergies;

    public function __construct()
    {
        $this->recetteIngredients = new ArrayCollection();
        $this->allergies = new ArrayCollection();
    }

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

    public function getCategorie(): ?CategoriesIngr
    {
        return $this->categorie;
    }

    public function setCategorie(?CategoriesIngr $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Allergies>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Allergies $allergy): self
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
            $allergy->setIngredient($this);
        }

        return $this;
    }

    public function removeAllergy(Allergies $allergy): self
    {
        if ($this->allergies->removeElement($allergy)) {
            // set the owning side to null (unless already changed)
            if ($allergy->getIngredient() === $this) {
                $allergy->setIngredient(null);
            }
        }

        return $this;
    }
}
