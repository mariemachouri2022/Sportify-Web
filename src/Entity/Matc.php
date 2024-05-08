<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MatcRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MatcRepository::class)]
class Matc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ID_Matc", type: "integer")]
    
    private ?int $idMatc=null;

    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nom=null;

 
   #[ORM\Column(length:100)]
   #[Assert\NotBlank(message: "Le type ne peut pas être vide.")]
   #[Assert\Choice(
       choices: ['Normal', 'Custom', 'Ranked'],
       message: "Veuillez choisir un type valide."
   )]
    private ?string $type=null;

   #[ORM\Column(type: Types::DATE_MUTABLE)]
   #[Assert\NotBlank(message: "La date ne peut pas être vide.")]
    #[Assert\GreaterThan(
        value: "today",
        message: "La date doit être postérieure à aujourd'hui."
    )]
    #[Assert\LessThan(
        value: "+15 days",
        message: "La date ne peut pas dépasser 15 jours à partir d'aujourd'hui."
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: "L'heure ne peut pas être vide.")]
    private ?\DateTimeInterface $heure = null;
   
    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide.")]
    #[Assert\Length(
        min: 10,
        max: 30,
        minMessage: "La description doit contenir au moins {{ limit }} caractères.",
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $description=null;
    #[ORM\ManyToOne(targetEntity: Equipe::class)]
    #[ORM\JoinColumn(name: 'Equipe1', referencedColumnName: 'IDEquipe')]
    private ?Equipe $Equipe1 = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class)]
    #[ORM\JoinColumn(name: 'Equipe2', referencedColumnName: 'IDEquipe')]
    private ?Equipe $Equipe2 = null;

    #[ORM\ManyToOne(inversedBy: 'matcs')]
    #[ORM\JoinColumn(name: 'arbitre', referencedColumnName: 'id_arbitre')]
    private ?Arbitre $arbitre = null;
    
    

    public function getIdMatc(): ?int
    {
        return $this->idMatc;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    
    

    




    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

   

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->Equipe1;
    }

    public function setEquipe1(?Equipe $Equipe1): static
    {
        $this->Equipe1 = $Equipe1;

        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->Equipe2;
    }

    public function setEquipe2(?Equipe $Equipe2): static
    {
        $this->Equipe2 = $Equipe2;

        return $this;
    }

    public function getArbitre(): ?arbitre
    {
        return $this->arbitre;
    }

    public function setArbitre(?arbitre $arbitre): static
    {
        $this->arbitre = $arbitre;

        return $this;
    }
   

   

}
