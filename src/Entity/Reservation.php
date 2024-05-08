<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ID_Reservation", type: "integer")]
    private ?int $idReservation = null;

    #[ORM\Column(name: "Date_Heure", type: "datetime")]
    #[Assert\NotBlank(message: "Date and Time cannot be blank")]
    private ?DateTime $dateHeure = null;

    #[ORM\Column(name: "Duree", length: 15)] // Set maximum length to 15 characters
    #[Assert\NotBlank(message: "Duration cannot be blank")]
    #[Assert\Regex(
        pattern: '/^(?!0000$).*$/',
        message: "Duration cannot be '0000'"
    )]
    private ?string $duree = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id", nullable: false)]
    private ?Utilisateurs $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(name: "id_Terrain", referencedColumnName: "id_Terrain", nullable: false)]
    private ?Terrain $idTerrain = null;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getDateHeure(): ?DateTime
    {
        return $this->dateHeure;
    }

    public function setDateHeure(?DateTime $dateHeure): self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getIdTerrain(): ?Terrain
    {
        return $this->idTerrain;
    }

    public function setIdTerrain(?Terrain $idTerrain): self
    {
        $this->idTerrain = $idTerrain;

        return $this;
    }

    // Callback function to validate date range
    #[Assert\Callback(callback: 'validateDateRange')]
    public function validateDateRange(ExecutionContextInterface $context)
    {
        $year = $this->dateHeure->format('Y');
        if ($year < 2024 || $year > 2025) {
            $context->buildViolation('The date must be between 2024 and 2025.')
                ->atPath('dateHeure')
                ->addViolation();
        }
    }
}
