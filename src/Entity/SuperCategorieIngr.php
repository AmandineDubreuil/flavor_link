<?php

namespace App\Entity;

use App\Repository\SuperCategorieIngrRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuperCategorieIngrRepository::class)]
class SuperCategorieIngr
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $superCategorie = null;

    #[ORM\OneToMany(mappedBy: 'superCategorieIngr', targetEntity: CategoriesIngr::class)]
    private Collection $categorie;

    #[ORM\OneToMany(mappedBy: 'superCategorieIngr', targetEntity: Allergies::class)]
    private Collection $allergies;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->allergies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuperCategorie(): ?string
    {
        return $this->superCategorie;
    }

    public function setSuperCategorie(string $superCategorie): self
    {
        $this->superCategorie = $superCategorie;

        return $this;
    }

    /**
     * @return Collection<int, CategoriesIngr>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(CategoriesIngr $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
            $categorie->setSuperCategorieIngr($this);
        }

        return $this;
    }

    public function removeCategorie(CategoriesIngr $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getSuperCategorieIngr() === $this) {
                $categorie->setSuperCategorieIngr(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->superCategorie;
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
            $allergy->setSuperCategorieIngr($this);
        }

        return $this;
    }

    public function removeAllergy(Allergies $allergy): self
    {
        if ($this->allergies->removeElement($allergy)) {
            // set the owning side to null (unless already changed)
            if ($allergy->getSuperCategorieIngr() === $this) {
                $allergy->setSuperCategorieIngr(null);
            }
        }

        return $this;
    }

}
