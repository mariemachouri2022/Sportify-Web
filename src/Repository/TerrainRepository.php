<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Terrain>
 *
 * @method Terrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terrain[]    findAll()
 * @method Terrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

//    /**
//     * @return Terrain[] Returns an array of Terrain objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Terrain
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }






public function triertype()
    {
        return $this->createQueryBuilder('terrain')
            ->orderBy('terrain.prix', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function TrieMontantdes()
    {
        return $this->createQueryBuilder('terrain')
            ->orderBy('terrain.prix', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function countClub()
        {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('count(Terrain.validite)');
            $qb->from('App\Entity\Terrain', 'terrain');
    
            $count = $qb->getQuery()->getSingleScalarResult();
    
            return $count;
        }




}
