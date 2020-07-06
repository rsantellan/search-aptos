<?php

namespace App\Repository;

use App\Entity\FocusPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FocusPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method FocusPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method FocusPoint[]    findAll()
 * @method FocusPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FocusPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FocusPoint::class);
    }

    // /**
    //  * @return FocusPoint[] Returns an array of FocusPoint objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FocusPoint
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
