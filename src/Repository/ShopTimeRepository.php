<?php

namespace App\Repository;

use App\Entity\ShopTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShopTime>
 *
 * @method ShopTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopTime[]    findAll()
 * @method ShopTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopTime::class);
    }

//    /**
//     * @return ShopTime[] Returns an array of ShopTime objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ShopTime
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
