<?php
/**
 * @copyright Copyright © 2019 Geocom. All rights reserved.
 * @author    Rodrigo Santellan <rsantellan@geocom.com.uy>
 */

namespace App\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Apartamento;

class ApartamentoRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Apartamento::class);
    }

    /**
     * @param bool $active
     * @param bool $possible
     * @param bool $inMap
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function doCount($active = true, $possible = true, $inMap = true)
    {
        $data = ['active' => $active];
        $qb = $this->createQueryBuilder('p')
            ->select('count(p.url)')
            ->andWhere('p.active = :active');
        if($possible !== null){
            $qb->andWhere('p.possible = :possible');
            $data['possible'] = $possible;
        }

        $qb->setParameters($data);
        if($inMap !== null){
            if($inMap){
                $qb->andWhere('p.latitud is not null');
            }else{
                $qb->andWhere('p.latitud is null');
            }
        }

        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * @return mixed
     */
    public function getAllActive($startPage = 0, $limit = 20)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager
                        ->createQuery('select a from App\Entity\Apartamento a where a.active = :active order by a.price asc')
                        ->setParameter('active', true)
                        ->setFirstResult($startPage)
                        ->setMaxResults($limit)
                        ;
        return $query->execute();
    }

    public function getAllActiveMarkers()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager
            ->createQuery('select a.name, a.url, a.active, a.latitud, a.longitud from App\Entity\Apartamento a where a.active = :active and a.latitud is not null')
            ->setParameter('active', true)
        ;
        return $query->execute();
    }
}