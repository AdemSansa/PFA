<?php

namespace App\Repository;

use App\Entity\OrdersDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrdersDetails>
 *
 * @method OrdersDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdersDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdersDetails[]    findAll()
 * @method OrdersDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdersDetails::class);
    }

        /**
         * @return OrdersDetails[] Returns an array of OrdersDetails objects
         */
        public function Listall($id): array
        {
            return $this->createQueryBuilder('od')
                ->Join('od.orders', 'o')
                ->andWhere('o.id = :id')
                ->setParameter('id',$id)   
                ->getQuery()
                ->getResult();
        }

    //    public function findOneBySomeField($value): ?OrdersDetails
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
