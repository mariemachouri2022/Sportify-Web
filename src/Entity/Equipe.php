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
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(name: "IDEquipe", type: "integer")]
    private ?int $IDEquipe = null;

    #[ORM\Column(length: 255)]
  /*  #[Assert\NotBlank(message: "Le nom ne doit pas être vide.")]
    #[Assert\Length(
        min: 8,
        max: 200,
        minMessage: 'Le nom doit faire au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne doit pas faire plus de {{ limit }} caractères'
    )]*/
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
  /*  #[Assert\NotBlank(message: "Le niveau ne doit pas être vide.")]
    #[Assert\Length(
        min: 8,
        max: 200,
        minMessage: 'Le niveau doit faire au moins {{ limit }} caractères',
        maxMessage: 'Le niveau ne doit pas faire plus de {{ limit }} caractères'
    )]*/
    private ?string $niveau = null;

    #[ORM\Column(type: "boolean")]
    #[Assert\NotBlank(message: "Le Random ne doit pas être vide.")]
    private ?bool $israndom = null;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "Le rank ne doit pas être vide.")]
    #[Assert\PositiveOrZero(message: 'Le rank ne peut pas être négatif')]
    private ?int $rank = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: "IDCateg", referencedColumnName: "IDCateg")]
    #[Assert\NotBlank(message: "La catégorie ne doit pas être vide.")]
    private ?Categorie $IDCateg = null;

    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'equipe')]
    private Collection $utilisateurs;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $created_at = null;

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
            $utilisateur->setEquipe($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // Remove the relationship
            $utilisateur->setEquipe(null);
        }

        return $this;
    }
     
    public function getIDEquipe(): ?int
    {
        return $this->IDEquipe;
    }
    public function getCreated_at(): ?int
    {
        return $this->created_at;
    }

    public function setCreated_at(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
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

}
