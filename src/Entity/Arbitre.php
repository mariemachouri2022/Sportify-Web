<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArbitreRepository;

#[ORM\Entity(repositoryClass: ArbitreRepository::class)]
class Arbitre

{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idArbitre=null;

  
    #[ORM\Column(length:255)]
    private ?string $nom=null;

    
    #[ORM\Column(length:65535)]
    private ?string $prenom=null;

   
    #[ORM\Column(length:255)]
    private ?string $email=null;

    
    #[ORM\Column(length:255)]
    private ?string $phone=null;

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


}
