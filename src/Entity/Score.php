<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ScoreRepository;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idscore=null;

    #---------
    #[ORM\Column]
    private ?int $competitionid=null;


    #---------
    #[ORM\Column]
    private ?int $winnerid=null;

   #---------
   #[ORM\Column]
    private ?int $loserid=null;

   #---------
   #[ORM\Column]
    private ?int $equipe1score=null;

   #---------
   #[ORM\Column]
    private ?int $equipe2score=null;

    
    #[ORM\Column(length:65535)]
    private ?string $resultat=null;

    
    #[ORM\Column(length:65535)]
    private ?string $reclamation=null;

    public function getIdscore(): ?int
    {
        return $this->idscore;
    }

    public function getCompetitionid(): ?int
    {
        return $this->competitionid;
    }

    public function setCompetitionid(?int $competitionid): static
    {
        $this->competitionid = $competitionid;

        return $this;
    }

    public function getWinnerid(): ?int
    {
        return $this->winnerid;
    }

    public function setWinnerid(?int $winnerid): static
    {
        $this->winnerid = $winnerid;

        return $this;
    }

    public function getLoserid(): ?int
    {
        return $this->loserid;
    }

    public function setLoserid(?int $loserid): static
    {
        $this->loserid = $loserid;

        return $this;
    }

    public function getEquipe1score(): ?int
    {
        return $this->equipe1score;
    }

    public function setEquipe1score(?int $equipe1score): static
    {
        $this->equipe1score = $equipe1score;

        return $this;
    }

    public function getEquipe2score(): ?int
    {
        return $this->equipe2score;
    }

    public function setEquipe2score(?int $equipe2score): static
    {
        $this->equipe2score = $equipe2score;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(?string $resultat): static
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getReclamation(): ?string
    {
        return $this->reclamation;
    }

    public function setReclamation(?string $reclamation): static
    {
        $this->reclamation = $reclamation;

        return $this;
    }


}
