<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecettesRepository::class)]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?int $tpsPreparation = null;

    #[ORM\Column]
    private ?int $tpsCuisson = null;

    #[ORM\Column]
    private ?int $tpsRepos = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $preparation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $saison = null;

    #[ORM\Column]
    private ?int $nbPersonnes = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'recetteId', targetEntity: RecetteIngredients::class)]
    private Collection $ingredients;

    #[ORM\Column(length: 255)]
    private ?string $ingredientsAll = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTpsPreparation(): ?int
    {
        return $this->tpsPreparation;
    }

    public function setTpsPreparation(int $tpsPreparation): self
    {
        $this->tpsPreparation = $tpsPreparation;

        return $this;
    }

    public function getTpsCuisson(): ?int
    {
        return $this->tpsCuisson;
    }

    public function setTpsCuisson(int $tpsCuisson): self
    {
        $this->tpsCuisson = $tpsCuisson;

        return $this;
    }

    public function getTpsRepos(): ?int
    {
        return $this->tpsRepos;
    }

    public function setTpsRepos(int $tpsRepos): self
    {
        $this->tpsRepos = $tpsRepos;

        return $this;
    }

    public function getPreparation(): ?string
    {
        return $this->preparation;
    }

    public function setPreparation(string $preparation): self
    {
        $this->preparation = $preparation;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSaison(): ?string
    {
        return $this->saison;
    }

    public function setSaison(string $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getNbPersonnes(): ?int
    {
        return $this->nbPersonnes;
    }

    public function setNbPersonnes(int $nbPersonnes): self
    {
        $this->nbPersonnes = $nbPersonnes;

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
     * @return Collection<int, RecetteIngredients>
     * 
     */

     public function __toString(): string
     {
         return $this->getId();  // or some string field in your Vegetal Entity 
     }

    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(RecetteIngredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecetteId($this);
        }

        return $this;
    }

    public function removeIngredient(RecetteIngredients $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecetteId() === $this) {
                $ingredient->setRecetteId(null);
            }
        }

        return $this;
    }

    public function getIngredientsAll(): ?string
    {
        return $this->ingredientsAll;
    }

    public function setIngredientsAll(string $ingredientsAll): self
    {
        $this->ingredientsAll = $ingredientsAll;

        return $this;
    }

}
