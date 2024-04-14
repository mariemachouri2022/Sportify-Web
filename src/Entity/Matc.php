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
    #[ORM\Column]
    private ?int $idMatc=null;

    #[ORM\Column(length:100)]
    private ?string $nom=null;

 
   #[ORM\Column(length:100)]
    private ?string $type=null;

  
    #[ORM\Column]
    private ?DateTime $date=null;

    #[ORM\Column]
    private ?DateTime $heure=null;

    #[ORM\Column(length:255)]
    private ?string $description=null;
     

    #-----------
    #[ORM\Column]
    private ?int $equipe1=null;


    #------------
    #[ORM\Column]
    private ?int $equipe2=null;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): static
    {
        $this->heure = $heure;

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

    public function getEquipe1(): ?int
    {
        return $this->equipe1;
    }

    public function setEquipe1(?int $equipe1): static
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getEquipe2(): ?int
    {
        return $this->equipe2;
    }

    public function setEquipe2(?int $equipe2): static
    {
        $this->equipe2 = $equipe2;

        return $this;
    }


}
