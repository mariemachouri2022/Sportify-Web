<?php

namespace App\Repository;

use App\Entity\Classementuser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classementuser>
 *
 * @method Classementuser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classementuser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classementuser[]    findAll()
 * @method Classementuser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classementuser::class);
    }

//    /**
//     * @return Classementuser[] Returns an array of Classementuser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Classementuser
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
