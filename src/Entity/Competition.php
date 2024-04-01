<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use App\Repository\CompetitionRepository;
use App\Entity\Equipe ;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ID_Competition", type: "integer")]
    private ?int $idCompetition=null;

    #[ORM\Column(length:100)]
    private ?string $nom=null;

    #[ORM\Column(length:50)]
    private ?string $type=null;

    #[ORM\Column]
    private ?DateTime $date=null;

    #[ORM\Column]
    private ?DateTime $heure=null;

    #[ORM\Column(length:255)]
    private ?string $description=null;

     #[ORM\ManyToOne(inversedBy:'competitions')]   
     #[ORM\JoinColumn(name: 'terrain_id', referencedColumnName: 'id_terrain')]
     private ?Terrain $terrain=null;
      
    

    #[ORM\ManyToOne(targetEntity: Equipe::class)]
    #[ORM\JoinColumn(name: 'equipe1_id', referencedColumnName: 'IDEquipe')]
    private ?Equipe $equipe1 = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class)]
    #[ORM\JoinColumn(name: 'equipe2_id', referencedColumnName: 'IDEquipe')]
    private ?Equipe $equipe2=null;


    public function getIdCompetition(): ?int
    {
        return $this->idCompetition;
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

    public function getTerrain(): ?Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?Terrain $terrain): static
    {
        $this->terrain = $terrain;

        return $this;
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->equipe1;
    }

    public function setEquipe1(?Equipe $equipe1): static
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->equipe2;
    }

    public function setEquipe2(?Equipe $equipe2): static
    {
        $this->equipe2 = $equipe2;

        return $this;
    }


}
