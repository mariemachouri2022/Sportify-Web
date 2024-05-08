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

    #[ORM\ManyToOne(targetEntity: Competition::class)]
    #[ORM\JoinColumn(name: 'competitionId', referencedColumnName: 'ID_Competition')]
    private ?Competition $competitionId=null;


    
    #[ORM\ManyToOne(targetEntity: Equipe::class)]
    #[ORM\JoinColumn(name: 'winnerId', referencedColumnName: 'IDEquipe')]
    private ?Equipe $winnerId = null; 
    
    #[ORM\ManyToOne(targetEntity: Equipe::class)]
    #[ORM\JoinColumn(name: 'loserId', referencedColumnName: 'IDEquipe')]
    private ?Equipe $loserId = null;

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

    public function getCompetitionid(): ?Competition
    {
        return $this->competitionId;
    }

    public function setCompetitionid(?Competition $competitionId): static
    {
        $this->competitionId = $competitionId;

        return $this;
    }

    public function getWinnerid(): ?Equipe
    {
        return $this->winnerId;
    }

    public function setWinnerid(?Equipe $winnerId): static
    {
        $this->winnerId = $winnerId;

        return $this;
    }

    public function getLoserid(): ?Equipe
    {
        return $this->loserId;
    }

    public function setLoserid(?Equipe $loserId): static
    {
        $this->loserId = $loserId;

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
