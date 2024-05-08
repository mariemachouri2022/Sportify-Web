<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArbitreRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArbitreRepository::class)]
class Arbitre

{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_arbitre", type: "integer")]

    private ?int $idArbitre=null;

  
    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nom=null;

    
    #[ORM\Column(length:65535)]
    #[Assert\NotBlank(message: "Le prenom ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: "Le prenom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le prenom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $prenom=null;

   
    #[ORM\Column(length:255)]
    #[Assert\Email(message: 'The email {{ value }} is not a valid email.',)]
    #[Assert\NotBlank(message: "vous devez mettre votre email!!!")]
    private ?string $email=null;

    
    #[ORM\Column(length:255)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\d{8}$/',message:"le numero doit etre 8 chiffres")]
    private ?string $phone=null;

    #[ORM\OneToMany(mappedBy: 'arbitre', targetEntity: Matc::class)]
    private Collection $matcs;

    public function __construct()
    {
        $this->matcs = new ArrayCollection();
    }

    public function getIdArbitre(): ?int
    {
        return $this->idArbitre;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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
            $matc->setArbitre($this);
        }

        return $this;
    }

    public function removeMatc(Matc $matc): static
    {
        if ($this->matcs->removeElement($matc)) {
            // set the owning side to null (unless already changed)
            if ($matc->getArbitre() === $this) {
                $matc->setArbitre(null);
            }
        }

        return $this;
    }



}
