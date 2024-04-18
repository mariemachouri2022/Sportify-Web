<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MatcRepository;

#[ORM\Entity(repositoryClass: MatcRepository::class)]
class Matc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ID_Matc", type: "integer")]
    
    private ?int $idMatc=null;

    #[ORM\Column(length:100)]
    private ?string $nom=null;

 
   #[ORM\Column(length:100)]
    private ?string $type=null;

   #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure = null;
   
    #[ORM\Column(length:255)]
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
