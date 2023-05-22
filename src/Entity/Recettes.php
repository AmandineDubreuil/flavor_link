<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
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
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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
}
