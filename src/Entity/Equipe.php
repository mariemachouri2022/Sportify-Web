<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipeRepository;
use App\Entity\Categorie;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "IDEquipe", type: "integer")]
    private ?int $IDEquipe = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne doit pas être vide.")]
    #[Assert\NoSuspiciousCharacters]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le niveau ne doit pas être vide.")]
    private ?string $niveau = null;

    #[ORM\Column(type: "boolean")]
    #[Assert\NotBlank(message: "Le Random ne doit pas être vide.")]
    private ?bool $israndom = null;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "Le rank ne doit pas être vide.")]
    #[Assert\Positive(message: "Le rank doit être un nombre positif.")]
    private ?int $rank = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: "IDCateg", referencedColumnName: "IDCateg")]
    #[Assert\NotBlank(message: "La catégorie ne doit pas être vide.")]
    private ?Categorie $IDCateg = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'equipes', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'equipe_members')]
    private Collection $utilisateurs;
   
    
    
    public function getIDEquipe(): ?int
    {
        return $this->IDEquipe;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function isIsrandom(): ?bool
    {
        return $this->israndom;
    }

    public function setIsrandom(bool $israndom): self
    {
        $this->israndom = $israndom;
        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;
        return $this;
    }

    public function getIDCateg(): ?Categorie
    {
        return $this->IDCateg;
    }

    public function setIDCateg(?Categorie $IDCateg): self
    {
        $this->IDCateg = $IDCateg;
        return $this;
    }

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
    }

    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }
}

