<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipeRepository;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "IDEquipe", type: "integer")]
    private ?int $IDEquipe = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $niveau = null;

    #[ORM\Column(type: "boolean")]
    private ?bool $israndom = null;

    #[ORM\Column(type: "integer")]
    private ?int $rank = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: 'IDCateg', referencedColumnName: 'IDCateg')]
    private ?Categorie $IDCateg = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]   
    private ?Utilisateur $id_user = null;

    public function getIdEquipe(): ?int
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

    public function getIdcateg(): ?Categorie
    {
        return $this->IDCateg;
    }

    public function setIdcateg(?Categorie $IDCateg): self
    {
        $this->IDCateg = $IDCateg;
        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->id_user;
    }

    public function setIdUser(?Utilisateur $id_user): self
    {
        $this->id_user = $id_user;
        return $this;
    }

  
    /*
     * @return Collection<int, Competition>
     
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    /*public function addCompetition(Competition $competition): static
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions->add($competition);
            $competition->setEquipe1($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): static
    {
        if ($this->competitions->removeElement($competition)) {
            // set the owning side to null (unless already changed)
            if ($competition->getEquipe1() === $this) {
                $competition->setEquipe1(null);
            }
        }

        return $this;
    }*/
}
