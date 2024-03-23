<?php

namespace App\Repository;

use App\Entity\Classementequipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classementequipe>
 *
 * @method Classementequipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classementequipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classementequipe[]    findAll()
 * @method Classementequipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementEquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classementequipe::class);
    }

//    /**
//     * @return Classementequipe[] Returns an array of Classementequipe objects
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

//    public function findOneBySomeField($value): ?Classementequipe
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
