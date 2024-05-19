<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

        /**
         * @return Livre[] Returns an array of Livre objects
         */
        public function findGreaterThan($prix): array
        {
            return $this->createQueryBuilder('l')
                ->andWhere('l.prix = :val')
                ->setParameter('val', $prix)
                ->orderBy('l.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findBooksSoldQuantityBetweenDates(\DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->createQueryBuilder('l')
            ->select('l.titre', 'SUM(od.Qte) AS total_quantity')
            ->join('l.ordersDetails', 'od')
            ->join('od.orders', 'o')
            ->where('o.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->groupBy('l.titre')
            ->getQuery();

        return $qb->getResult();
    }


     //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

   
