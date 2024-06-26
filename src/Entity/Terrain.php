<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TerrainRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_Terrain", type: "integer")]
    private ?int $id_Terrain = null;

    #[ORM\Column(length:255)]
    private ?string $nom = null;
   
    #[ORM\Column(name: "type_surface", length:255)]
    private ?string $typeSurface = null;

    #[ORM\Column(length:255)]
    private ?string $localisation = null;
    #[ORM\Column(type: "float")]
    #[Assert\NotBlank(message: "Le prix est requis")]
    #[Assert\Range(
        max: 500,
        maxMessage: "Le prix ne peut pas dépasser {{ limit }}"
    )]
    private ?float $prix = null;
    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $promotion = null;

    #[ORM\Column(name: "id_proprietaire", type: "integer")]
    private ?int $idProprietaire = null;

    #[ORM\Column(name: "image_ter", length:255)]
    private ?string $imageTer = null;

    public function getIdTerrain(): ?int
    {
        return $this->id_Terrain;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeSurface(): ?string
    {
        return $this->typeSurface;
    }

    public function setTypeSurface(?string $typeSurface): static
    {
        $this->typeSurface = $typeSurface;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdProprietaire(): ?int
    {
        return $this->idProprietaire;
    }

    public function setIdProprietaire(?int $idProprietaire): static
    {
        $this->idProprietaire = $idProprietaire;

        return $this;
    }

    public function getImageTer(): ?string
    {
        return $this->imageTer;
    }

    public function setImageTer(?string $imageTer): static
    {
        $this->imageTer = $imageTer;

        return $this;
    }
    public function getPromotion(): ?int
    {
        return $this->promotion;
    }

    public function setPromotion(?int $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
}
