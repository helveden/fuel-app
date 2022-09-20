<?php

namespace App\Repository;

use App\Entity\Pdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pdv>
 *
 * @method Pdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pdv[]    findAll() 
 * @method Pdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pdv::class);
    }

    public function add(Pdv $entity, bool $flush = false): Pdv
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        
        return $entity;
    }

    public function remove(Pdv $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Pdv[] Returns an array of Pdv objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

public function findByPostcode($value): array
{
    return $this->createQueryBuilder('p')
        ->andWhere('p.postalcode LIKE :postalcode')
        ->setParameter('postalcode', $value)
        ->orderBy('p.city', 'ASC')
        ->getQuery()
        ->getResult()
    ;
}

/*
* Requete SQL
*
*  https://numa-bord.com/miniblog/doctrine-recherche-table-contenant-latitudes-longitudes-celle-situes-a-de-xx-km/
*
*
*
*/


//    public function findOneBySomeField($value): ?Pdv
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
