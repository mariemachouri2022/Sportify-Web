<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClassementUserRepository;


#[ORM\Entity(repositoryClass: ClassementUserRepository::class)]
Class Classementuser
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id=null ;

    #-------
    #[ORM\Column()]
    private ?int $userId=null;

    #[ORM\Column()]
    private ?int $points=null;

    #[ORM\Column()]
    private ?int $rank=null;

    #[ORM\Column()]
    private ?int $nbreDeMatch=null;

    #[ORM\Column()]
    private ?int $win=null;

    #[ORM\Column()]
    private ?int $draw=null;

    #[ORM\Column()] 
    private ?int $loss=null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): static
    {
        $this->rank = $rank;

        return $this;
    }

    public function getNbreDeMatch(): ?int
    {
        return $this->nbreDeMatch;
    }

    public function setNbreDeMatch(int $nbreDeMatch): static
    {
        $this->nbreDeMatch = $nbreDeMatch;

        return $this;
    }

    public function getWin(): ?int
    {
        return $this->win;
    }

    public function setWin(int $win): static
    {
        $this->win = $win;

        return $this;
    }

    public function getDraw(): ?int
    {
        return $this->draw;
    }

    public function setDraw(int $draw): static
    {
        $this->draw = $draw;

        return $this;
    }

    public function getLoss(): ?int
    {
        return $this->loss;
    }

    public function setLoss(int $loss): static
    {
        $this->loss = $loss;

        return $this;
    }


}
