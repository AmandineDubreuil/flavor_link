<?php

namespace App\Entity;

use App\Repository\AmisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AmisRepository::class)]
class Amis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column]
    private ?int $nbPersonnes = null;

    #[ORM\ManyToOne(inversedBy: 'amis')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Recettes::class, inversedBy: 'amis')]
    private Collection $recettes;

    #[ORM\ManyToMany(targetEntity: Repas::class, mappedBy: 'amis')]
    private Collection $repas;

    #[ORM\OneToMany(mappedBy: 'ami', targetEntity: Allergies::class)]
    private Collection $allergies;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
        $this->repas = new ArrayCollection();
        $this->allergies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
     * @return Collection<int, Recettes>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recettes $recette): self
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
        }

        return $this;
    }

    public function removeRecette(Recettes $recette): self
    {
        $this->recettes->removeElement($recette);

        return $this;
    }

    /**
     * @return Collection<int, Repas>
     */

    public function __toString(): string
    {
        return $this->getNom();
    }

    public function getRepas(): Collection
    {
        //  dd($this->repas);
        return $this->repas;
    }

    public function addRepa(Repas $repa): self
    {
        if (!$this->repas->contains($repa)) {
            $this->repas->add($repa);
            $repa->addAmi($this);
        }

        return $this;
    }

    public function removeRepa(Repas $repa): self
    {
        if ($this->repas->removeElement($repa)) {
            $repa->removeAmi($this);
        }

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
            $allergy->setAmi($this);
        }

        return $this;
    }

    public function removeAllergy(Allergies $allergy): self
    {
        if ($this->allergies->removeElement($allergy)) {
            // set the owning side to null (unless already changed)
            if ($allergy->getAmi() === $this) {
                $allergy->setAmi(null);
            }
        }

        return $this;
    }


}
