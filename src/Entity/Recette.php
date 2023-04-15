<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Met $met = null;

    #[ORM\ManyToMany(targetEntity: Methode::class, inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $methodes;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Mesure::class, inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mesures;

    public function __construct()
    {
        $this->methodes = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->mesures = new ArrayCollection();
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

    public function getMet(): ?Met
    {
        return $this->met;
    }

    public function setMet(?Met $met): self
    {
        $this->met = $met;

        return $this;
    }

    /**
     * @return Collection<int, Methode>
     */
    public function getMethodes(): Collection
    {
        return $this->methodes;
    }

    public function addMethode(Methode $methode): self
    {
        if (!$this->methodes->contains($methode)) {
            $this->methodes->add($methode);
        }

        return $this;
    }

    public function removeMethode(Methode $methode): self
    {
        $this->methodes->removeElement($methode);

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection<int, Mesure>
     */
    public function getMesures(): Collection
    {
        return $this->mesures;
    }

    public function addMesure(Mesure $mesure): self
    {
        if (!$this->mesures->contains($mesure)) {
            $this->mesures->add($mesure);
        }

        return $this;
    }

    public function removeMesure(Mesure $mesure): self
    {
        $this->mesures->removeElement($mesure);

        return $this;
    }
}
