<?php

namespace App\Entity;

use App\Repository\CategoriesIngrRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesIngrRepository::class)]
class CategoriesIngr
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $categorie = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Ingredients::class)]
    private Collection $ingredients;

    #[ORM\ManyToOne(inversedBy: 'categorie')]
    private ?SuperCategorieIngr $superCategorieIngr = null;

    #[ORM\OneToMany(mappedBy: 'categorieIngredients', targetEntity: Allergies::class)]
    private Collection $allergies;

       public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->allergies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setCategorie($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getCategorie() === $this) {
                $ingredient->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->categorie;
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
            $allergy->setCategorieIngredients($this);
        }

        return $this;
    }

    public function removeAllergy(Allergies $allergy): self
    {
        if ($this->allergies->removeElement($allergy)) {
            // set the owning side to null (unless already changed)
            if ($allergy->getCategorieIngredients() === $this) {
                $allergy->setCategorieIngredients(null);
            }
        }

        return $this;
    }

 }
