<?php

namespace App\Repository;

use App\Entity\Matc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matc>
 *
 * @method Matc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matc[]    findAll()
 * @method Matc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matc::class);
    }

//    /**
//     * @return Matc[] Returns an array of Matc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Matc
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
