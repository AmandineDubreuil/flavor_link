<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecettesRepository::class)]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?int $tpsPreparation = null;

    #[ORM\Column(nullable: true)]
    private ?int $tpsCuisson = null;

    #[ORM\Column(nullable: true)]
    private ?int $tpsRepos = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $preparation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?int $nbPersonnes = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'recetteId', targetEntity: RecetteIngredients::class)]
    private Collection $ingredients;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ingredientsAll = null;

    #[ORM\ManyToMany(targetEntity: Amis::class, mappedBy: 'recettes')]
    private Collection $amis;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Repas::class)]
    private Collection $repas;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $saison = [];

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?CategoriesRecette $categoriesRecette = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->amis = new ArrayCollection();
        $this->repas = new ArrayCollection();
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

    /**
     * @return Collection<int, Amis>
     */
    public function getAmis(): Collection
    {
        return $this->amis;
    }

    public function addAmi(Amis $ami): self
    {
        if (!$this->amis->contains($ami)) {
            $this->amis->add($ami);
            $ami->addRecette($this);
        }

        return $this;
    }

    public function removeAmi(Amis $ami): self
    {
        if ($this->amis->removeElement($ami)) {
            $ami->removeRecette($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Repas>
     */
    public function getRepas(): Collection
    {
        //  dd($this->repas);

        return $this->repas;
    }

    public function addRepa(Repas $repa): self
    {
        if (!$this->repas->contains($repa)) {
            $this->repas->add($repa);
            $repa->setRecette($this);
        }

        return $this;
    }

    public function removeRepa(Repas $repa): self
    {
        if ($this->repas->removeElement($repa)) {
            // set the owning side to null (unless already changed)
            if ($repa->getRecette() === $this) {
                $repa->setRecette(null);
            }
        }

        return $this;
    }

    public function getSaison(): array
    {
        return $this->saison;
    }

    public function setSaison(?array $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getCategoriesRecette(): ?CategoriesRecette
    {
        return $this->categoriesRecette;
    }

    public function setCategoriesRecette(?CategoriesRecette $categoriesRecette): self
    {
        $this->categoriesRecette = $categoriesRecette;

        return $this;
    }
}
