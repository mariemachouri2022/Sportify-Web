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

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: "IDCateg", referencedColumnName: "IDCateg")]
    private ?Categorie $IDCateg = null;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: "id_createur", referencedColumnName: "id")]
    private ?Utilisateurs $idUser = null;

    #[ORM\OneToMany(mappedBy: 'Equipe1', targetEntity: Matc::class)]
    private Collection $matcs;
    #[ORM\OneToMany(mappedBy: 'Equipe2', targetEntity: Matc::class)]
    private Collection $matcs2;

    public function __construct()
    {
        $this->matcs = new ArrayCollection();
        $this->matcs2 = new ArrayCollection();

    }
    

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

    public function getIdUser(): ?Utilisateurs
    {
        return $this->idUser;
    }

    public function setIdUser(?Utilisateurs $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, Matc>
     */
    public function getMatcs(): Collection
    {
        return $this->matcs;
    }

    public function addMatc(Matc $matc): static
    {
        if (!$this->matcs->contains($matc)) {
            $this->matcs->add($matc);
            $matc->setEquipe1($this);
        }

        return $this;
    }

    public function removeMatc(Matc $matc): static
    {
        if ($this->matcs->removeElement($matc)) {
            // set the owning side to null (unless already changed)
            if ($matc->getEquipe1() === $this) {
                $matc->setEquipe1(null);
            }
        }

        return $this;
    }
    public function getMatcs2(): Collection
    {
        return $this->matcs2;
    }

    public function addMatc2(Matc $matc): static
    {
        if (!$this->matcs2->contains($matc)) {
            $this->matcs2->add($matc);
            $matc->setEquipe2($this);
        }

        return $this;
    }

    public function removeMatc2(Matc $matc): static
    {
        if ($this->matcs2->removeElement($matc)) {
            // set the owning side to null (unless already changed)
            if ($matc->getEquipe2() === $this) {
                $matc->setEquipe2(null);
            }
        }

        return $this;
    }
}


