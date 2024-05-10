<?php

namespace App\Repository;

use App\Entity\CP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CP>
 *
 * @method CP|null find($id, $lockMode = null, $lockVersion = null)
 * @method CP|null findOneBy(array $criteria, array $orderBy = null)
 * @method CP[]    findAll()
 * @method CP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CP::class);
    }

    //    /**
    //     * @return CP[] Returns an array of CP objects
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

    //    public function findOneBySomeField($value): ?CP
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
