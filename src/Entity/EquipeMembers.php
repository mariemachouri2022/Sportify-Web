<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipeMembersRepository;

#[ORM\Entity(repositoryClass: EquipeMembersRepository::class)]
#[ORM\Table(name: "equipe_members")]
class EquipeMembers
{
    #[ORM\Id]
    #[ORM\Column(name: "equipe_id", type: "integer")]
    private $equipeId;

    #[ORM\Id]
    #[ORM\Column(name: "user_id", type: "integer")]
    private $userId;

    public function getEquipeId(): ?int
    {
        return $this->equipeId;
    }

    public function setEquipeId(int $equipeId): self
    {
        $this->equipeId = $equipeId;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
}
