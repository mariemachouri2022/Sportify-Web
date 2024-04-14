<?php

namespace App\Repository;

use App\Entity\EquipeMembers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipeMembers>
 *
 * @method EquipeMembers|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipeMembers|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipeMembers[]    findAll()
 * @method EquipeMembers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeMembersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipeMembers::class);
    }

//    /**
//     * @return EquipeMembers[] Returns an array of EquipeMembers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EquipeMembers
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
