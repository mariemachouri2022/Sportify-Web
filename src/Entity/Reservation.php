<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idReservation=null;

    #[ORM\Column]
    private ?DateTime $dateHeure=null;

  
    #[ORM\Column(length:255)]
    private ?string $duree=null;

    #[ORM\ManyToOne(inversedBy:'utilisateurs')]   
    private ?Utilisateur $id=null;

    
    #[ORM\ManyToOne(inversedBy:'terrains')]   
    private ?Terrain $idTerrain=null;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(?\DateTimeInterface $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getId(): ?Utilisateur
    {
        return $this->id;
    }

    public function setId(?Utilisateur $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdTerrain(): ?Terrain
    {
        return $this->idTerrain;
    }

    public function setIdTerrain(?Terrain $idTerrain): static
    {
        $this->idTerrain = $idTerrain;

        return $this;
    }


}
