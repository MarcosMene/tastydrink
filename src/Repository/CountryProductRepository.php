<?php

namespace App\Repository;

use App\Entity\CountryProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CountryProduct>
 *
 * @method CountryProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryProduct[]    findAll()
 * @method CountryProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CountryProduct::class);
    }

//    /**
//     * @return CountryProduct[] Returns an array of CountryProduct objects
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

//    public function findOneBySomeField($value): ?CountryProduct
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
